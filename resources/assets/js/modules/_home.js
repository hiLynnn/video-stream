class Home{
    constructor(){
        this.events();
    }
    events(){
        console.log("Run home scripts!");
        $(document).on('click','.close-btn',function(){
            $('.ads-script').css('display','none')
        })
        this.videoSwiper();
    }
    videoSwiper(){
        const swiper = new Swiper('.swiper-reel', {
            direction: 'vertical',
            loop: false,
            mousewheel: true
        });
    }
}
export default Home;
