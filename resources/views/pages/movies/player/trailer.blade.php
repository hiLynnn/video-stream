 
<div id="viavi_trailer" style="margin:auto;"></div>
 

 <!-- Setup EVP -->
 <script type="text/javascript">
			 FWDEVPUtils.onReady(function(){
 
				 FWDEVPlayer.videoStartBehaviour = "pause";
				 
				 new FWDEVPlayer({		
					 //main settings
					 instanceName:"player2",
					 parentId:"viavi_trailer",
					 mainFolderPath:"{{URL::asset('/site_assets/player/content/')}}",
					 initializeOnlyWhenVisible:"no",
					 skinPath:"{{ get_player_cong('player_style') }}",
					 displayType:"lightbox", 
					 autoScale:"yes",
					 fillEntireVideoScreen:"no",
					 playsinline:"yes",
					 useWithoutVideoScreen:"no",
					 openDownloadLinkOnMobile:"no",
					 googleAnalyticsMeasurementId:"",
					 useVectorIcons:"{{get_player_cong('player_vector_icons')}}",
					 useResumeOnPlay:"yes",
					 goFullScreenOnButtonPlay:"no",
					 useHEXColorsForSkin:"no",
					 normalHEXButtonsColor:"#FF0000",
					 privateVideoPassword:"428c841430ea18a70f7b06525d4b748a",
					 startAtVideoSource:0,
					 startAtTime:"",
					 stopAtTime:"",
					 videoSource:[
						 {source:"encrypt:{{base64_encode($movies_info->trailer_url)}}", label:"", isLive:"no"},						  
					 ],
					 posterPath:"{{URL::to('/'.$movies_info->video_image)}}",
					 showErrorInfo:"yes",
					 fillEntireScreenWithPoster:"no",
					 disableDoubleClickFullscreen:"no",
					 useChromeless:"no",
					 showPreloader:"yes",
					 preloaderColors:["#999999", "#FFFFFF"],
					 addKeyboardSupport:"yes",
					 autoPlay:"{{get_player_cong('autoplay')}}",
					 autoPlayText:"Click to Unmute",
					 loop:"yes",
					 scrubAtTimeAtFirstPlay:"00:00:00",
					 maxWidth:750,
					 maxHeight:425,
					 volume:.8,
					 greenScreenTolerance:200,
					 backgroundColor:"#000000",
					 posterBackgroundColor:"#000000",
					 //lightbox settings
					 closeLightBoxWhenPlayComplete:"no",
					 lightBoxBackgroundOpacity:.6,
					 lightBoxBackgroundColor:"#000000",
					 //logo settings
					 logoSource:"{{ get_player_cong('player_logo')? URL::asset('/'.get_player_cong('player_logo')) : URL::asset('/'.getcong('site_logo')) }}",
					 showLogo:"{{get_player_cong('player_watermark')}}",
					 hideLogoWithController:"yes",
					 logoPosition:"{{get_player_cong('player_logo_position')}}",
					 logoLink:"{{get_player_cong('player_url')}}",
					 logoMargins:5,
					 //controller settings
					 showController:"yes",
					 showDefaultControllerForVimeo:"yes",
					 showScrubberWhenControllerIsHidden:"yes",
					 showControllerWhenVideoIsStopped:"yes",
					 showVolumeScrubber:"yes",
					 showVolumeButton:"yes",
					 showTime:"yes",
					 showAudioTracksButton:"yes",
					 showRewindButton:"{{get_player_cong('rewind_forward')}}",
					 showQualityButton:"yes",
					 showShareButton:"no",
					 showEmbedButton:"no",
					 showDownloadButton:"no",
					 showMainScrubberToolTipLabel:"yes",
					 showChromecastButton:"yes",
					 how360DegreeVideoVrButton:"no",
					 showFullScreenButton:"yes",
					 repeatBackground:"no",
					 controllerHeight:43,
					 controllerHideDelay:3,
					 startSpaceBetweenButtons:11,
					 spaceBetweenButtons:11,
					 mainScrubberOffestTop:15,
					 scrubbersOffsetWidth:2,
					 timeOffsetLeftWidth:1,
					 timeOffsetRightWidth:2,
					 volumeScrubberWidth:80,
					 volumeScrubberOffsetRightWidth:0,
					 timeColor:"#bdbdbd",
					 showYoutubeRelAndInfo:"no",
					 youtubeQualityButtonNormalColor:"#888888",
					 youtubeQualityButtonSelectedColor:"#FFFFFF",
					 scrubbersToolTipLabelBackgroundColor:"#FFFFFF",
					 scrubbersToolTipLabelFontColor:"#5a5a5a",
					 //redirect at video end
					 redirectURL:"",
					 redirectTarget:"_blank",
					 //cuepoints
					 executeCuepointsOnlyOnce:"no",
					 cuepoints:[],
					 //annotations
					 annotiationsListId:"none",
					 showAnnotationsPositionTool:"no",
					 //subtitles
					 showSubtitleButton:"no",
					 subtitlesOffLabel:"Subtitle off",
					 startAtSubtitle:1,
					 subtitlesSource:[						 
						   
					 ],
					 //audio visualizer
					 audioVisualizerLinesColor:"#0099FF",
					 audioVisualizerCircleColor:"#FFFFFF",
					 //advertisement on pause window
					 aopwTitle:"Advertisement",
					 aopwSource:"",
					 aopwWidth:400,
					 aopwHeight:240,
					 aopwBorderSize:6,
					 aopwTitleColor:"#FFFFFF",
					 //playback rate / speed
					 showPlaybackRateButton:"yes",
					 defaultPlaybackRate:"1", //0.25, 0.5, 1, 1.25, 1.5, 2
					 //sticky on scroll
					 stickyOnScroll:"yes",
					 stickyOnScrollShowOpener:"yes",
					 stickyOnScrollWidth:"700",
					 stickyOnScrollHeight:"394",
					 //sticky display settings
					 showOpener:"yes",
					 showOpenerPlayPauseButton:"yes",
					 verticalPosition:"bottom",
					 horizontalPosition:"center",
					 showPlayerByDefault:"yes",
					 animatePlayer:"yes",
					 openerAlignment:"right",
					 mainBackgroundImagePath:"{{URL::asset('/site_assets/player/content/minimal_skin_dark/main-background.png')}}",
					 openerEqulizerOffsetTop:-1,
					 openerEqulizerOffsetLeft:3,
					 offsetX:0,
					 offsetY:0,
					  
					 //embed window
					 embedWindowCloseButtonMargins:15,
					 borderColor:"#333333",
					 mainLabelsColor:"#FFFFFF",
					 secondaryLabelsColor:"#a1a1a1",
					 shareAndEmbedTextColor:"#5a5a5a",
					 inputBackgroundColor:"#000000",
					 inputColor:"#FFFFFF",
					 //a to b loop
					 useAToB:"no",
					 atbTimeBackgroundColor:"transparent",
					 atbTimeTextColorNormal:"#FFFFFF",
					 atbTimeTextColorSelected:"#FF0000",
					 atbButtonTextNormalColor:"#888888",
					 atbButtonTextSelectedColor:"#FFFFFF",
					 atbButtonBackgroundNormalColor:"#FFFFFF",
					 atbButtonBackgroundSelectedColor:"#000000",
					 //thumbnails preview
					 thumbnailsPreview:"auto",
					 thumbnailsPreviewWidth:196,
					 thumbnailsPreviewHeight:110,
					 thumbnailsPreviewBackgroundColor:"#000000",
					 thumbnailsPreviewBorderColor:"#666",
					 thumbnailsPreviewLabelBackgroundColor:"#666",
					 thumbnailsPreviewLabelFontColor:"#FFF",
					 // context menu
					 contextMenuType:'default',
					 showScriptDeveloper:"no",
					 contextMenuBackgroundColor:"#1b1b1b",
					 contextMenuBorderColor:"#1b1b1b",
					 contextMenuSpacerColor:"#333",
					 contextMenuItemNormalColor:"#bdbdbd",
					 contextMenuItemSelectedColor:"#FFFFFF",
					 contextMenuItemDisabledColor:"#333",
					   
				 });
 
			 });
		 </script>