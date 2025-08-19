// JavaScript Document
/*Asokaロゴがスクロールで小さくなるのとロゴクリックでページトップに戻るスクリプト*/
var logo = document.getElementById('logo');

if (logo) {
    window.addEventListener('scroll', function() {
      var title = document.querySelector('.site-title');
      if (window.pageYOffset > 0) {
        logo.style.height = '60px';
        logo.style.backgroundSize = '50% 100%';
        logo.style.backgroundPosition = 'left top';
        if(title) title.style.opacity = '0';
      } else {
        logo.style.height = '120px';
        logo.style.backgroundSize = '100% 100%';
        logo.style.backgroundPosition = 'left bottom';
        if(title) title.style.opacity = '1';
      }
    });

    logo.addEventListener('click', function() {
      window.scrollTo({top: 0, behavior: 'smooth'});
    });
}


/*メニュークリックでスクロール*/
$(document).ready(function(){
  $('a[href^="#"]').click(function(){
    var speed = 1000;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    $("html, body").animate({scrollTop:position}, speed, "swing");
    return false;
  });
});


// ================================================================
// 全ページ共通レスポンシブメニュー
// ================================================================
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menuItems = document.querySelector('.menu-items');
    const menuLinks = document.querySelectorAll('.menu-item > a');

    if (menuToggle && menuItems) {
        // ハンバーガーボタンのクリックイベント
        menuToggle.addEventListener('click', function() {
            this.classList.toggle('is-active');
            menuItems.classList.toggle('is-open');

            // メニューが開いている間、背景のスクロールを禁止
            if (menuItems.classList.contains('is-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        // サブメニューを持つ項目に対する処理
        const itemsWithSubmenu = document.querySelectorAll('.menu-item-has-children');
        itemsWithSubmenu.forEach(item => {
            item.addEventListener('click', function(event) {
                // モバイルビューでのみ動作
                if (window.innerWidth <= 923) {
                    // サブメニューのリンク自体をクリックした場合はページ遷移を許可
                    if (event.target.closest('.submenu')) {
                        return;
                    }
                    
                    // 親メニューのリンクをクリックした場合、サブメニューを開閉
                    event.preventDefault();
                    this.classList.toggle('is-open');
                }
            });
        });

        // メニュー内のリンクをクリックしたらメニューを閉じる（モバイル時）
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 923 && !link.parentElement.classList.contains('menu-item-has-children')) {
                    menuToggle.classList.remove('is-active');
                    menuItems.classList.remove('is-open');
                    document.body.style.overflow = '';
                }
            });
        });
    }

    // ウィンドウリサイズ時の処理
    window.addEventListener('resize', function() {
        if (window.innerWidth > 923) {
            // PC表示になったら、モバイル用のクラスとスタイルをリセット
            if (menuToggle.classList.contains('is-active')) {
                menuToggle.classList.remove('is-active');
            }
            if (menuItems.classList.contains('is-open')) {
                menuItems.classList.remove('is-open');
            }
            document.body.style.overflow = '';
            // サブメニュー用のクラスもリセット
            document.querySelectorAll('.menu-item.is-open').forEach(item => {
                item.classList.remove('is-open');
            });
        }
    });
});


//iframeの高さ自動調整
document.addEventListener('DOMContentLoaded', function() {
  const iframe = document.getElementById('myIframe');
  if (iframe) {
      iframe.addEventListener('load', function() {
        try {
            const iframeBody = iframe.contentWindow.document.body;
            const iframeHeight = iframeBody.scrollHeight;
            iframe.style.height = iframeHeight + 'px';
        } catch (e) {
            console.error("iframeの高さ調整に失敗しました。", e);
        }
      });
  }
});

//お問合せフォームのフリガナ自動入力
function validateKana(input) {
  input.value = input.value.replace(/[^ァ-ヶー　]/g, '');
}