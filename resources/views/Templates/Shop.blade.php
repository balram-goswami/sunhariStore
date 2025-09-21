<div id="page-content">
    <!--Collection Banner-->
    <div class="collection-header" style="margin-bottom: 30px;">
        <div class="collection-hero">
            <div class="collection-hero__image"><img class="blur-up lazyload"
                    data-src="{{ publicPath('themeAssets//images/cat-women2.jpg') }}"
                    src="{{ publicPath('themeAssets//images/cat-women2.jpg') }}" alt="Women" title="Women" /></div>
            <div class="collection-hero__title-wrapper">
                <h1 class="collection-hero__title page-width">Shop</h1>
            </div>
        </div>
    </div>
    <!--End Collection Banner-->

    <div class="container">
        <div class="row">
            <!--Sidebar-->
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 sidebar filterbar">
                <div class="closeFilter d-block d-md-none d-lg-none"><i class="icon icon anm anm-times-l"></i></div>
                <div class="sidebar_tags">
                    <!--Categories-->
                    <div class="sidebar_widget categories filter-widget">
                        <div class="widget-title">
                            <h2>Categories</h2>
                        </div>
                        <div class="widget-content">
                            <ul class="sidebar_categories">
                                <li class=""><a href="" class="site-nav">Categories</a>
                                    <ul>
                                        @foreach ($categories as $cat)
                                        <label>
                                            <input type="checkbox" class="filter-category"
                                                value="{{ $cat->id }}">
                                            {{ $cat->name }}
                                        </label>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class=""><a href="#;" class="site-nav">Fabric</a>
                                    <ul class="sublinks">
                                        @foreach ($brands as $brand)
                                        <li>
                                            <label>
                                                <input type="checkbox" class="filter-brand"
                                                    value="{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-9 col-lg-9 main-col">
                <div class="category-description">
                    <h3></h3>
                </div>
                <hr>
                <div class="productList">
                    <!--Toolbar-->
                    <button type="button" class="btn btn-filter d-block d-md-none d-lg-none"> Product
                        Filters</button>
                    <div class="toolbar">
                        <div class="filters-toolbar-wrapper">
                            <div class="row">
                                <div
                                    class="col-4 col-md-4 col-lg-4 filters-toolbar__item collection-view-as d-flex justify-content-start align-items-center">
                                    <a href="shop-left-sidebar.html" title="Grid View"
                                        class="change-view change-view--active">
                                        <img src="{{ publicPath('themeAssets//images/grid.jpg') }}" alt="Grid" />
                                    </a>
                                    <a href="shop-listview.html" title="List View" class="change-view">
                                        <img src="{{ publicPath('themeAssets//images/list.jpg') }}" alt="List" />
                                    </a>
                                </div>
                                <div
                                    class="col-4 col-md-4 col-lg-4 text-center filters-toolbar__item filters-toolbar__item--count d-flex justify-content-center align-items-center">
                                    <span class="filters-toolbar__product-count product-count">Showing: {{ $products->count() }} of {{ $products->total() }}</span>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4 text-right">
                                    <div class="filters-toolbar__item">
                                        <label for="SortBy" class="hidden">Sort</label>
                                        <select name="SortBy" id="SortBy"
                                            class="filters-toolbar__input filters-toolbar__input--sort">
                                            <option value="title-ascending" selected="selected">Sort</option>
                                            @php
                                            $sort_by_list = [
                                            'price_low_to_high' => 'Price (Low to High)',
                                            'price_high_to_low' => 'Price (High to Low)',
                                            'new_to_old' => 'Latest',
                                            'old_to_new' => 'Oldest',
                                            ];
                                            $sort_by = request()->sort_by && isset($sort_by_list[request()->sort_by])
                                            ? request()->sort_by
                                            : 'new_to_old';
                                            @endphp
                                            @foreach ($sort_by_list as $key => $value)
                                            @php
                                            $selected = $key == $sort_by ? 'selected' : '';
                                            @endphp
                                            <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <input class="collection-header__default-sort" type="hidden" value="manual">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--End Toolbar-->

                    <div class="grid-products grid--view-items">
                        <div class="row">
                            @if ($products->count() > 0)

                            <div class="product-list row" data-page="{{ $products->currentPage() }}" data-last-page="{{ $products->lastPage() }}" data-total-pages="{{ $products->total() }}" data-to="{{ $products->count() }}">
                                @foreach ($products as $items)
                                @include('components.product-card', ['items' => $items])
                                @endforeach
                            </div>

                            <div class="loading-spinner loading-spinner-product text-center">Loading...</div>
                            @else
                            <div class="col-12 text-center mt-4">
                                <p>No Product Found, try another category or brand.</p>
                            </div>
                            @endif

                            
                        </div>
                    </div>
                </div>
                <hr class="clear">
                <div class="pagination">
                    <ul>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li class="next"><a href="#"><i class="fa fa-caret-right"
                                    aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>