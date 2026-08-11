$('#carouselExample').on('slide.bs.carousel', function (e) {
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 5;
    var totalItems = $('.carousel-item').length;
    
    if (idx >= totalItems-(itemsPerSlide-1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i=0; i<it; i++) {
            // append slides to end
            if (e.direction=="left") {
                $('.carousel-item').eq(i).appendTo('.carousel-inner');
            }
            else {
                $('.carousel-item').eq(0).appendTo('.carousel-inner');
            }
        }
    }
});

  $(document).ready(function() {

  });

  function nextTip(i){
    $(".tips").hide("slow")
    $('.tips#tip-'+i).animate({height: "toggle", opacity: "toggle"}, "slow");
  }
  $(function(){
    var i = 2;
    var total = $('.tips').length;
    var i = setInterval(() => {
      if (i > total)
        i = 1;
      nextTip(i);
      i++;
    }, 10000);

    $('button#search').click(()=>{
      
    })
  })