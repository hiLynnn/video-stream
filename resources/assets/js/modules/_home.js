class Home{
    constructor(){
        this.cusorPage = '';
        this.swiper = null;
        this.events();
    }
    videoJsUpdate(ids = []){
        ids.forEach(function(item,index){
            const video = videojs(`my-video-${item}`, {});
        })

    }
    events(){
        console.log("Run home scripts!");
        $(document).on('click','.close-btn',function(){
            $('.ads-script').css('display','none')
        })
        this.videoSwiper();
        this.getVideos();
    }
    videoSwiper(){
        this.swiper = new Swiper('.swiper-reel', {
            direction: 'vertical',
            loop: false,
            mousewheel: true
        });
    }
    getVideos(){
        const _main = this;
        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            method: "GET",
            url: "/api/v1/video",
            data: {},
            success: function({ data }) {
                _main.swiper.appendSlide(data.html);
                _main.videoJsUpdate(data.id_reload)
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }
}
export default Home;
