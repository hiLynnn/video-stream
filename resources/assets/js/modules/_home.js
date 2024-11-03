class Home{
    constructor(){
        this.cusorPage = '';
        this.swiper = null;
        this.listVideoIds = [];
        this.currentPlayer = null;
        this.events();
    }
    loading(mode=true){
        if(mode){
            $('#layer-loading-page').addClass('active')
        } else {
            $('#layer-loading-page').removeClass('active')
        }
    }
    videoJsUpdate(ids = []){
        const _main = this;
        ids.forEach(function(item,index){
            const videoId = `my-video-${item}`;
            const player =  videojs(videoId);

            _main.listVideoIds.push(
                { id: videoId, player : player }
            );
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
        const _main = this;
        this.swiper = new Swiper('.swiper-reel', {
            direction: 'vertical',
            loop: false,
            mousewheel: true,
            on: {
                slideChange: function () {
                    const prevIndex = this.previousIndex;
                    const prevSlide = $(this.slides[prevIndex]);
                    const videoElement = prevSlide.find('video');
                    if (videoElement) {
                        const videoId = videoElement.data("origin-id");
                        const data = _main.listVideoIds.filter((e,i)=> e.id == videoId);
                        if(data && data.length > 0){
                            const player = data[0].player
                            player.pause();
                        }
                    }
                }
            }
        });
    }
    getVideos(){
        const _main = this;
        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            method: "GET",
            url: "/api/v1/video",
            data: {},
            beforeSend:function(){
                _main.loading(true);
            },
            success: function({ data }) {
                _main.swiper.appendSlide(data?.html);
                _main.videoJsUpdate(data?.id_reload);
                _main.cusorPage = data?.next_page_url;
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            },
            complete:function(){
                _main.loading(false);
            }
        });
    }
}
export default Home;
