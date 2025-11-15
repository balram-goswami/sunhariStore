<style>
    /* WhatsApp button styling */
    .btn-whatsapp {
        background-color: #25D366 !important;
        color: #fff !important;
        border: none;
        padding: 10px 18px;
        font-weight: 600;
        font-size: 15px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-align: center;
        white-space: nowrap;
        width: auto;
        box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);
    }

    .btn-whatsapp i {
        font-size: 18px;
    }

    .btn-whatsapp:hover {
        background-color: #1EBE5D !important;
        box-shadow: 0 6px 14px rgba(37, 211, 102, 0.45);
        transform: translateY(-2px);
    }

    .btn-whatsapp:active {
        transform: scale(0.97);
    }

    /* 📱 Mobile View */
    @media only screen and (max-width: 1024px) {
        .btn-whatsapp {
            width: 100%;
            font-size: 14px;
            padding: 10px 14px;
            border-radius: 10px;
            justify-content: center;
            background-color: #25D366 !important;
            color: #fff !important;
        }
    }
</style>
<div class="variants add text-center mt-2">
    <a href="{{ url('/order-whatsapp/' . $items->id) }}"
        class="btn btn-whatsapp"
        target="_blank" rel="noopener">
        <i class="fa fa-whatsapp"></i> Order on WhatsApp
    </a>
</div>