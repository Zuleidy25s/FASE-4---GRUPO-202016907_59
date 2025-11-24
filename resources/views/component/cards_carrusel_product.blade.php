<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .slick-img img {
        width: 100%;
        height: auto;
        margin-right: 10px;
    }

    .slick-img .item {
        padding: 5px;
        box-sizing: border-box;
    }

    .slick-img .item img {
        display: block;
        margin: 0 auto;
    }

    .slick-img .item span {
        display: block;
        text-align: center;
        margin-top: 5px;
    }

    .prev-btn, .next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.5);
        padding: 5px;
        cursor: pointer;
    }

    .prev-btn {
        left: 10px;
    }

    .next-btn {
        right: 10px;
    }
    .slick-dots{
        display: none !important;
    }
</style>

<div class="mx-5">
    <span class="my-4 h5 lead d-flex" style="font-weight: 600;">Lo mejor y lo mas nuevo</span>
    <div class="row slick-img responsive">
        <div class="item">
            <img src="/static/img/camisa1.jpg" alt="Imagen 1">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
        <div class="item">
            <img src="https://images.pexels.com/photos/1232459/pexels-photo-1232459.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Imagen 2">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
        <div class="item">
            <img src="https://images.pexels.com/photos/2635314/pexels-photo-2635314.jpeg?auto=compress&cs=tinysrgb&w=600&lazy=load" alt="Imagen 3">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
        <div class="item">
            <img src="https://images.pexels.com/photos/769732/pexels-photo-769732.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Imagen 4">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
        <div class="item">
            <img src="https://images.pexels.com/photos/6069556/pexels-photo-6069556.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Imagen 5">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
        <div class="item">
            <img src="https://images.pexels.com/photos/20585267/pexels-photo-20585267/free-photo-of-blanco-y-negro-mujer-sentado-silla.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Imagen 6">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
        <div class="item">
            <img src="https://images.pexels.com/photos/6616112/pexels-photo-6616112.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Imagen 7">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
        <div class="item">
            <img src="https://images.pexels.com/photos/10948505/pexels-photo-10948505.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Imagen 8">
            <span class="d-flex mx-2 my-4 h5" style="font-weight: 600;">Camisa hombre</span>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js" integrity="sha512-eP8DK17a+MOcKHXC5Yrqzd8WI5WKh6F1TIk5QZ/8Lbv+8ssblcz7oGC8ZmQ/ZSAPa7ZmsCU4e/hcovqR8jfJqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.responsive').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 5,
        centerMode: true,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
        });
</script>