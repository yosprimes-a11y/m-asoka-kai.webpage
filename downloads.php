<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>ダウンロード - 必要なデータをダウンロードできます</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:700,400">
    <link rel="shortcut icon" href="/favicon2.ico">
    <link rel="icon" href="/images/favicon2.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/downloads.min.css"> <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> </head>
<body>
    <div class="header">
        <div class="container">
            <div class="header-left">
                <a href="index.html"><img class="header-logo" src="images/asokalogoxmini.png" alt="sub-logo"></a>
            </div>
            <div class="header-right">
                <button class="menu-toggle" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <nav class="menu-items">
                    <ul>
                        <li class="menu-item"><a href="index.html#latest-news">お知らせ</a></li>
                        <li class="menu-item">
                            <a href="index.html#philosophy">法人について</a>
                            <div class="submenu">
                                <a href="houjin.html">理事長挨拶</a>
                                <a href="houjin.html#hist">法人沿革</a>
                                <a href="index.html#philosophy">法人理念</a>
                                <a href="reportssp.html">情報開示</a>
                            </div>
                        </li>
                        <li class="menu-item">
                            <a href="index.html#works">事業について</a>
                            <div class="submenu">
                                <a href="akagi.html">赤城野荘</a>
                                <a href="kou.html">光明園</a>
                                <a href="tan.html">たんぽぽ</a>
                                <a href="yas.html">やすらぎ</a>
                                <a href="run.html">ルンビニー苑</a>
                            </div>
                        </li>
                        <li class="menu-item"><a href="index.html#skills">約束について</a></li>
                        <li class="menu-item"><a href="recruit.html">採用について</a></li>
                        <li class="menu-item"><a href="downloads.php">ダウンロード</a></li> <li class="menu-item"><a href="policy.html">サイトポリシー</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="box1">
        <h1>ダウンロード</h1>
        <h2>必要なデータをダウンロードできます</h2>
        <ul id="download-list">
            <?php
            $dir = "uploads/";
            // .と..を除外し、ファイル名でソート
            $files = array_diff(scandir($dir), array('.', '..'));
            // ファイル名の降順でソート（新しいファイルが上に来るように）
            usort($files, function($a, $b) use ($dir) {
                return filemtime($dir . $b) <=> filemtime($dir . $a);
            });

            foreach ($files as $file) {
                $filePath = htmlspecialchars($dir . $file);
                $fileName = htmlspecialchars($file);
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                $iconClass = ''; // アイコンクラスを初期化

                switch (strtolower($fileExtension)) {
                    case 'pdf':
                        $iconClass = 'far fa-file-pdf';
                        break;
                    case 'doc':
                    case 'docx':
                        $iconClass = 'far fa-file-word';
                        break;
                    case 'xls':
                    case 'xlsx':
                    case 'xlsm':
                        $iconClass = 'far fa-file-excel';
                        break;
                    case 'ppt':
                    case 'pptx':
                        $iconClass = 'far fa-file-powerpoint';
                        break;
                    case 'zip':
                        $iconClass = 'far fa-file-archive';
                        break;
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        $iconClass = 'far fa-file-image';
                        break;
                    default:
                        $iconClass = 'far fa-file'; // その他のファイル
                        break;
                }
                echo "<li><a href='#' onclick='previewFile(\"" . $filePath . "\")'><i class=\"$iconClass\"></i> " . $fileName . "</a></li>";
            }
            ?>
        </ul>
    </div>

    <footer>
        <p>&copy; 2024 社会福祉法人前橋あそか会</p>
    </footer>
    <script>
        // PDFや画像ファイルを新しいタブで開く関数
        function previewFile(file) {
            window.open(file, '_blank');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const menuItems = document.querySelector('.menu-items');
            const menuItemsList = document.querySelectorAll('.menu-items > ul > .menu-item'); // 各トップレベルメニュー項目（li）

            if (menuToggle && menuItems) {
                menuToggle.addEventListener('click', function() {
                    menuToggle.classList.toggle('is-active'); // ボタンのアイコンを切り替える
                    menuItems.classList.toggle('is-open');   // メニューの表示/非表示を切り替える

                    // メニューが開いたときにbodyのスクロールを固定する（オプション）
                    if (menuItems.classList.contains('is-open')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                });

                // 各トップレベルメニュー項目にイベントリスナーを追加
                menuItemsList.forEach(item => {
                    const submenu = item.querySelector('.submenu'); // サブメニューがあるか確認

                    // サブメニューがあるメニュー項目のみクリックイベントを追加
                    if (submenu) {
                        item.addEventListener('click', function(event) {
                            // PC表示時は何もしない
                            if (window.innerWidth > 923) { // reportssp.css のブレークポイントに合わせる
                                return;
                            }

                            // クリックされたのがサブメニューのリンク自体でなければ（サブメニューの開閉）
                            if (!event.target.closest('.submenu a')) {
                                event.preventDefault(); // 親メニュー項目へのリンクを無効化
                                // クリックされたメニュー項目だけサブメニューをトグルし、他のサブメニューは閉じる
                                menuItemsList.forEach(otherItem => {
                                    if (otherItem !== item && otherItem.classList.contains('is-open')) {
                                        otherItem.classList.remove('is-open');
                                    }
                                });
                                item.classList.toggle('is-open'); // サブメニュー表示用のクラスを切り替え
                            }
                        });
                    }
                });
            }

            // ウィンドウサイズ変更時のメニュー表示制御（モバイル/PC切り替え）
            window.addEventListener('resize', function() {
                if (window.innerWidth > 923) { // reportssp.css のブレークポイントに合わせる
                    menuItems.classList.remove('is-open'); // PCサイズではis-openを削除
                    menuToggle.classList.remove('is-active'); // PCサイズではis-activeを削除
                    document.body.style.overflow = ''; // スクロール固定を解除
                }
            });
        });
    </script>
</body>
</html>