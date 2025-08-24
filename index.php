<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="description"
    content="前橋あそか会は、地域に根ざした社会福祉法人です。高齢者の方々や障がいのある方々に対して、様々なサービスを提供しています。赤城野荘、光明園、たんぽぽなど、複数の施設を運営しており、地域住民の方々との交流も盛んです。">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <meta name="google-site-verification" content="U5BBi-QAqCaZLy3a6oUmy0Pudaqh8W89OqC28zozIpE" />
  <title>社会福祉法人前橋あそか会-あなたと共に素敵な未来を創る</title>
  <link rel="canonical" href="https://m-asoka-kai.jp/">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:700,400">
  <link rel="shortcut icon" href="/favicon2.ico">
  <link rel="icon" href="/images/favicon2.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="css/style.min.css">
  <style>
        .news-list {
            width: 100%;
            max-width: 800px; /* 必要に応じて調整 */
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box;
        }
        .news-item {
            border-bottom: 1px dotted #ccc;
            padding: 8px 0;
            font-size: 0.9em; /* 文字サイズを小さめに */
            line-height: 1.4;
            display: flex;
            align-items: flex-start;
        }
        .news-item:last-child {
            border-bottom: none;
        }
        .news-date {
            flex-shrink: 0;
            width: 170px; /* 日付と曜日の幅を固定 */
            margin-right: 10px;
            color: #555;
        }
        .news-category {
            flex-shrink: 0;
            width: 170px; /* カテゴリの幅を固定 (重要なお知らせが収まるように調整) */
            margin-right: 10px;
            color: #007bff;
            font-weight: bold;
        }
        .news-title-link {
            flex-grow: 1;
            display: block;
            color: #333;
            text-decoration: none;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis; /* 1行リード文風 */
        }
        .news-title-link:hover {
            text-decoration: underline;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 3px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #007bff;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #e9e9e9;
        }
        .pagination span.current {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination span.disabled {
            color: #ccc;
            cursor: not-allowed;
        }

@media (max-width: 768px) {
    .news-item {
        flex-direction: column; /* 項目を縦に並べる */
        align-items: flex-start; /* 左寄せにする */
    }
    .news-date,
    .news-category {
        width: auto; /* 固定幅を解除 */
        margin-right: 0; /* 右マージンを解除 */
        margin-bottom: 5px; /* 縦方向の余白を追加 */
    }
    .news-title-link {
        white-space: normal; /* テキストの折り返しを許可 */
        text-overflow: clip; /* 省略記号を解除 */
        max-height: 3.2em; /* 約2行分の高さに制限 */
        overflow: hidden; /* 制限を超えた部分は非表示 */
    }
}
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    #logo, #logo2 {
      z-index: 1003 !important;
    }
  </style>
</head>

<body>
  <div id="logo"></div>
  <div id="logo2"></div>
  <div class="mini-title">社会福祉法人前橋あそか会</div>
  <header class="header">
    <div class="header-left">
      <a href="index.php"><img class="header-logo" src="images/asokalogoxmini.png" alt="sub-logo"></a>
    </div>
    <div class="header-right">
      <ul class="menu-items">
        <li class="menu-item"><a href="index.php#latest-news">お知らせ</a></li>
        <li class="menu-item menu-item-has-children">
          <a href="index.php#philosophy">法人について</a>
          <ul class="submenu">
            <li><a href="houjin.html">理事長挨拶</a></li>
            <li><a href="houjin.html#hist">法人沿革</a></li>
            <li><a href="index.php#philosophy">法人理念</a></li>
          </ul>
        </li>
        <li class="menu-item menu-item-has-children">
          <a href="index.php#works">事業について</a>
          <ul class="submenu">
            <li><a href="akagi.html">赤城野荘</a></li>
            <li><a href="kou.html">光明園</a></li>
            <li><a href="tan.html">たんぽぽ学園</a></li>
            <li><a href="yas.html">やすらぎ園</a></li>
            <li><a href="run.html">ルンビニー苑</a></li>
          </ul>
        </li>
        <li class="menu-item"><a href="index.php#skills">約束について</a></li>
        <li class="menu-item"><a href="recruit.html">採用について</a></li>
        <li class="menu-item"><a href="disclosure.php">情報開示・ダウンロード</a></li>
        <li class="menu-item"><a href="policy.html">サイトポリシー</a></li>
        <li class="menu-item"><a href="contactform.php">お問い合わせ</a></li>
      </ul>
      <button class="menu-toggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
  </header>

  <!--    <p class="site-title-sub">a</p>-->
  <h1 class="site-title">あなたと共に素敵な未来を創る</h1>
  <a href="index.php"><img class="header-logo" src="images/asokalogoxmini.png" alt="sub-logo"></a>
  <!--    <p class="site-description">b</p>-->
  <div class="img-box">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>　
  </div>
  <!--
    <div class="buttons">
      <a class="button" href="#philosophy">LEARN MORE</a>
      <a class="button button-showy" href="#contact">SEND MESSAGE</a>
    </div>
-->
  <!--  </header>-->

  <!--    最新のニュース　　-->
  <section class="latest-news" id="latest-news">
    <h2 class="heading">お知らせ</h2>
    <div class="iframe-container">
      <?php include 'news_cms/display.php'; ?>
    </div>
  </section>

  <section class="philosophy" id="philosophy">
    <h2 class="heading">法人理念</h2>
    <p class="philosophy-text1">
      あなたと共に素敵な未来を創る
    </p>
    <!--  <div id="toggleContent" class="hide">-->
    <p class="philosophy-text2">
      ~寄り添い・育て・支え合う地域の共同体~
    </p>
    <p class="philosophy-text3">
      <span class="indent">あなたとは日々働く職員・地域の人々・施設の利用者を指し、前橋あそか会はその「あなた」のことを常に考えている組織です。</span>
      <span class="indent">素敵な未来とは、人それぞれで定義も違うでしょう。私たちは、福祉施設として、職員が働く職場として、地域の人々の拠り所として、ここに様々な未来を描いていきたいと考えています。</span>
      <span
        class="indent">“地域のすべてのひとたちが安心・安全で暮らしていけるものになる”、“ご高齢の方が心安らかに体健やかに日々を過ごすことができる”、“様々な生きづらさを抱えるひとたちやこどもたちが、幸福感を味わえる”このような理想を私たちは掲げていきます。</span>
      <span class="indent">このことを常に忘れず念頭に置いて私たちは仕事をし、私たち自らの素敵な未来を創っていきます。</span>
    </p>
    <a href="houjin.html" class="more-btn">もっと詳しく</a>
    <!--  </div>-->
    <!--  <button id="toggleButton"><em>もっと見る</em></button>-->
  </section>

  <section class="works" id="works">
    <h2 class="heading">事業紹介</h2>
    <div class="works-wrapper">
      <div class="work-box 赤">
        <a href="akagi.html"><img class="work-image work-image-1" src="images/赤城野荘拠点マーク.png" alt="拠点1"></a>
      </div>
      <div class="work-box 光">
        <a href="kou.html"><img class="work-image work-image-2" src="images/光明園拠点マーク.png" alt="拠点2"></a>
      </div>
      <div class="work-box た">
        <a href="tan.html"><img class="work-image work-image-3" src="images/たんぽぽ拠点マーク.webp" alt="拠点3"></a>
      </div>
      <div class="work-box や">
        <a href="yas.html"><img class="work-image work-image-4" src="images/やすらぎ拠点マーク.png" alt="拠点4"></a>
      </div>
      <div class="work-box ル">
        <a href="run.html"><img class="work-image work-image-5" src="images/ルンビニー苑拠点マーク.png" alt="拠点5"></a>
      </div>
    </div>
  </section>


  <section class="skills" id="skills">
    <h2 class="heading">私たちの約束</h2>
    <div class="skills-wrapper">
      <div class="skill-box">
        <img src="images/川w.png" class="skill-icon" alt="川のアイコン"> <!-- 修正 -->
        <div class="skill-title">みなさまへ</div>
        <p class="skill-text">
           私たちは地域社会への深い愛情と誇りを持ち、日々の活動にその想いを込めています。<br>
           新しいアイデアを取り入れながら、誠実で持続可能な取り組みを実現しています。<br>
           そして、多岐にわたる地域貢献活動を通じて、地域社会の発展に寄与し、未来に向けた明るいビジョンを共有します。
        </p>
      </div>
      <div class="skill-box">
        <img src="images/友だちw.png" class="skill-icon" alt="友達のアイコン"> <!-- 修正 -->
        <div class="skill-title">利用される方へ</div>
        <p class="skill-text">
           私たちはサービスの使いやすさと話の伝わりやすさを大切にしています。<br>
           みなさまに、私たちのサービスを心地よく感じていただけることを目指しています。<br>
           そして、共に歩むことで、より良い未来を築いていきたいと願っています。
        </p>
      </div>
      <div class="skill-box">
        <img src="images/チームw.png" class="skill-icon" alt="チームのアイコン"> <!-- 修正 -->
        <div class="skill-title">職員へ</div>
        <p class="skill-text">
           学びの機会は無限です。<br>
           変化の激しい時代でも、楽しみながら、しなやかに対応できる力を育んでいます。<br>
           私たちは、未来への挑戦を心から楽しみ、手を取り合う仲間として、より良い世界を一緒に創っていくことを目指しています。
        </p>
      </div>
    </div>
  </section>

  <!--
<section class="contact" id="contact">
  <h2 class="heading">お問合せ</h2>
  <form class="contact-form">
    <input type="text" id="name" name="name" placeholder="お名前" oninput="validateKana(this)">
    <textarea name="message" placeholder="メッセージ"></textarea>
    <input type="submit" value="送信">
  </form>
</section>
-->
  <footer class="footer">
    <div class="social-buttons">
      <a href="https://www.instagram.com/akagi_no_sou" class="instagram-btn red" target="_blank">
        <i class="fab fa-instagram"></i> 赤城野荘 Instagram
      </a>
      <a href="https://www.instagram.com/koumyouen" class="instagram-btn blue" target="_blank">
        <i class="fab fa-instagram"></i> 光　明　園 Instagram
      </a>
      <a href="https://www.instagram.com/tanpopo_gakuen" class="instagram-btn yellow" target="_blank">
        <i class="fab fa-instagram"></i> たんぽぽ学園 Instagram
      </a>
      <a href="https://www.instagram.com/maebashi.asoka.yasuragi.dei" class="instagram-btn green" target="_blank">
        <i class="fab fa-instagram"></i> やすらぎ園 Instagram
      </a>
      <a href="https://www.instagram.com/asokarunbinien" class="instagram-btn purple" target="_blank">
        <i class="fab fa-instagram"></i> ルンビニー苑 Instagram
      </a>
      <a href="https://www.instagram.com/kiiro.pro" class="instagram-btn white" target="_blank">
        <i class="fab fa-instagram"></i> 幸せのベンチ Instagram
      </a>
    </div>
    © 2024 社会福祉法人前橋あそか会
  </footer>
  <script src="script/script.js"></script>
</body>

</html>