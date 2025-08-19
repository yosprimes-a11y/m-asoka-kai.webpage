//スムーススクロール
$(function(){
   // #で始まるアンカーをクリックした場合に処理
   $('[href^=#]').click(function() {
      // スクロールの速度
      var speed = 1000;// ミリ秒
      // アンカーの値取得
      var href= $(this).attr("href");
      // 移動先を取得
      var target = $(href == "#top" || href == "" ? 'html' : href);
      // 移動先を数値で取得
      var position = target.offset().top;
      // スムーススクロール
	  var sclpos = 30;
	  var scldurat = 1200;
      $('body,html').animate({scrollTop: position}, {duration: scldurat, easing: "easeOutExpo"});
	  
      return false;
   });
});
$(function(){
    $("#acrbtn").click(function () {
      $("#commentDescription").toggle("normal");
    });
});

//アップファイルのサムネイル表示
//画像が複数ある場合用 ※要jQuery
$(document).on("change", 'input[type="file"]', function(){
	
	if($(this).val() != ''){
		
		var current = $(this);
		current.closest('td').find('.previewImg').remove();
		var file = current.prop('files')[0];
		if(!file.type.match('image.*')){
			return;
		}
		var fileReader = new FileReader();
		fileReader.onloadend = function() {
			current.closest('td').prepend('<div class="previewImg"><img width="80" class="previewThumb" src="' + fileReader.result + '"/></div>');
		}
		fileReader.readAsDataURL(file);
	
	}
});
