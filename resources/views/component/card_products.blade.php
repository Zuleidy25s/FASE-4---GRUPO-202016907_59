<style>


    .item-product img {
        height: 380px;
        width: 280px;
    }

    .size-btn:hover {
        background-color: #e0e0e0;
    }

    .product-actions {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
    }

    .btn-cart {
        background-color: #007bff;
        color: #fff;
    }

    .btn-cart:hover {
        background-color: #0056b3;
    }

    .hover-favorite:hover{
        text-decoration: none;
    }

    .text-favorite:hover{
        color: #af0000 !important;
    }

    .prev-btn, .next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.5);
        padding: 5px;
        cursor: pointer;
    }
</style>
<div class="my-2 h5 lead w-75">
    <span class="lead mx-5" style="font-weight: 600;">Nueva colección</span>
</div>
<div class="mx-auto p-2" style="overflow-x: auto;">
    <div class="d-flex slick-img-product px-4 pt-3" id="products_list">
    </div>
</div>

{{-- product list --}}
<script src="{{ asset('static/js/site.js') }}"></script>