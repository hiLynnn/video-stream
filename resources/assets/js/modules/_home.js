class Home{
    constructor(){
        this.next_page_url = '';
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
        this.modalEvents();
    }
    pausePrevVideo(self, slider){
        const prevIndex = slider.previousIndex;
        const prevSlide = $(slider.slides[prevIndex]);
        const videoElement = prevSlide.find('video');
        if (videoElement) {
            const videoId = videoElement.data("origin-id");
            const data = self.listVideoIds.filter((e,i)=> e.id == videoId);
            if(data && data.length > 0){
                const player = data[0].player
                player.pause();
            }
        }
    }
    pushUrlState(self, slider){
        const activeIndex = slider.activeIndex;
        const activeSlide = $(slider.slides[activeIndex]);
        const videoUrl = activeSlide.find('.video-url').data('url');
        history.pushState({ page: "/" }, videoUrl, videoUrl);
    }
    videoSwiper(){
        const _main = this;
        this.swiper = new Swiper('.swiper-reel', {
            direction: 'vertical',
            loop: false,
            mousewheel: true,
            on: {
                slideChange: function () {
                    _main.pausePrevVideo(_main, this);
                    _main.pushUrlState(_main, this)
                },
                reachEnd: () => {
                    console.log("Reached the last slide!");
                    _main.loadMoreSlides(); // Call a function to load more slides if needed
                }
            }
        });
    }
    getVideos(){
        const _main = this;
        const video_current = $("#video-current").val() ?? 0;
        $.ajax({
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            method: "GET",
            url: "/api/v1/video",
            data: {except: video_current},
            beforeSend:function(){
                _main.loading(true);
            },
            success: function({ data }) {
                _main.swiper.appendSlide(data?.html);
                _main.videoJsUpdate(data?.id_reload);
                _main.next_page_url = data?.next_page_url;
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            },
            complete:function(){
                _main.loading(false);
            }
        });
    }
    loadMoreSlides(){
        const _main = this;
        const video_current = $("#video-current").val() ?? 0;
        if(_main.next_page_url){
            $.ajax({
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                method: "GET",
                url: _main.next_page_url,
                data: {except: video_current},
                beforeSend:function(){
                    _main.loading(true);
                },
                success: function({ data }) {
                    _main.swiper.appendSlide(data?.html);
                    _main.videoJsUpdate(data?.id_reload);
                    _main.next_page_url = data?.next_page_url;
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
    modalEvents(){
        $(document).on('click', '.video-model-layer, .modal-header span', function(){
            $("#modal-popup").removeClass('active');
        })
        $(document).on('click', '.open-modal', function(){
            $("#modal-popup").addClass('active');
        })
    }
}
export default Home;
