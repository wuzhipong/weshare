var mySwiper = new Swiper('.swiper-container', {
	direction: 'horizontal',
	//初始化Slide索引
	initialSlide: 2,
	loop: true,
	speed:500,//滑动速度，即slider自动滑动开始到结束的时间（单位ms），也是触摸滑动时释放至贴合的时间。
	autoplay:3000,
	
	autoplayDisableOnInteraction:false,
	/*用户操作swiper之后，是否禁止autoplay。默认为true：停止。
               如果设置为false，用户操作swiper之后自动切换不会停止，每次都会重新启动autoplay。
                操作包括触碰，拖动，点击pagination等。*/

    slidesPerView:1,//可显示数量
    
    effect:"slide",//切换效果
    
    centeredSlides:true,//默认状态下活动块居左，设定为true时，活动块会居中。
    
    slideToClickedSlide:true,
	// 如果需要分页器
	pagination: '.swiper-pagination',

	// 如果需要前进后退按钮
	nextButton: '.swiper-button-next',
	prevButton: '.swiper-button-prev',

	// 如果需要滚动条
	scrollbar: '.swiper-scrollbar',
   })