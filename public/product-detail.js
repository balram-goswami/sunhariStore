const product = {
    search: '',
    categories: [],
    brands: [],
    sort_by: '',
    page: 1,
    last_page: 1,
    total_pages: 0,
    current_page: 1,
    from: 1,
    to: 0,
    queryString: '',
    products: [],
    filter: false,
    product_list_element: document.querySelector('.product-list'),
    product_offset_element: document.querySelector('.product-offset'),
    product_count_element: document.querySelector('.product-count'),

    init() {
        this.total_pages = Number(this.product_list_element.dataset.totalPages);
        this.to = Number(this.product_list_element.dataset.to);
        this.appendProductsOnScroll();
        this.filterByBrand();
        this.filterByCategory();
        this.filterBySortBy();
    },

    filterBySortBy() {
        const sort_by = document.querySelector('.filter-sort-by');
        sort_by.addEventListener('change', async () => {
            this.filter = true;
            this.sort_by = sort_by.value;
            await this.getProducts();
            this.product_list_element.innerHTML = this.products 
            ? this.products : '<div class="col-12 text-center mt-4"><p>No Product Found, try another sort by.</p></div>';
            this.updateProductDetails();
        });
    },

    filterByBrand() {
        const brands = document.querySelectorAll('.filter-brand');
        brands.forEach(brand => {
            brand.addEventListener('change', async () => {
                this.filter = true;
                let brand_value = [];
                brands.forEach(brand => {
                    if(brand.checked) {
                        brand_value.push(brand.value);
                    }
                });
                this.brands = brand_value;
                await this.getProducts();
                this.product_list_element.innerHTML = this.products 
                ? this.products : '<div class="col-12 text-center mt-4"><p>No Product Found, try another brand.</p></div>';
                this.updateProductDetails();
            });
        });
    },

    filterByCategory() {
        const categories = document.querySelectorAll('.filter-category');
        categories.forEach(category => {
            category.addEventListener('change', async () => {
                this.filter = true;
                let category_value = [];
                categories.forEach(category => {
                    if(category.checked) {
                        category_value.push(category.value);
                    }
                });
                this.categories = category_value;
                await this.getProducts();
                this.product_list_element.innerHTML = this.products 
                ? this.products : '<div class="col-12 text-center mt-4"><p>No Product Found, try another category.</p></div>';
                this.updateProductDetails();
            });
        });
    },

    getQueryString() {
        let [requestString, queryString = {}] = window.location.href.split('?');

        const queryStringObject = new URLSearchParams(queryString);
        
        if(this.filter == false) {
            let incrementPage = Number(this.page) + 1;
            queryStringObject.set('page', incrementPage);
            this.page = incrementPage;
        }
        if(this.brands.length > 0) {
            queryStringObject.set('brands', this.brands.join(','));
        }
        if(this.categories.length > 0) {
            queryStringObject.set('categories', this.categories.join(','));
        }
        if(this.sort_by != '') {
            queryStringObject.set('sort_by', this.sort_by);
        }
        
        this.queryString = queryStringObject.toString();
    },

    async getProducts() {
        this.getQueryString();
        const response = await fetch(`${window.location.href}?${this.queryString}`,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Ajax-Request': 'true',
                'X-CSRF-TOKEN': window.csrfToken
            }
        });
        const data = await response.json();
        this.products = data.products;
        this.from = data.from;
        this.to = data.to;
        this.last_page = data.last_page;
        this.total_pages = data.total_pages;
        this.current_page = data.current_page;
    },

    appendProductsOnScroll() {
        const productLoadSpinnerSection = document.querySelector('.loading-spinner-product');
        new IntersectionObserver(async (entries) => {
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    if(this.to < this.total_pages) {
                        await this.getProducts();
                        this.product_list_element.insertAdjacentHTML('beforeend', this.products);
                        this.updateProductDetails();
                    } else {
                        console.log('no more products');
                        productLoadSpinnerSection.style.display = 'none';
                    }
                }
            }
        }, {
            root: null,
            rootMargin: '0px',
            threshold: 1.0
        }).observe(productLoadSpinnerSection);
    },

    updateProductDetails() {
        
        if(this.last_page) {
            this.product_list_element.dataset.lastPage = this.last_page;
        }
        if(this.total_pages) {
            this.product_list_element.dataset.totalPages = this.total_pages;
        }
        if(this.current_page) {
            this.product_list_element.dataset.currentPage = this.current_page;
        }
        if(this.from) {
            this.product_offset_element.textContent = this.from;
        }
        if(this.to) {
            this.product_count_element.textContent = this.to;
        }
    }
}

product.init();