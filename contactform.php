<?php
  session_start();
  $mode = 'input';
  $errors = [];

  // PHPMailer のクラスを読み込む
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP; // SMTPクラスも必要

  // PHPMailer のファイルを読み込む (lib フォルダに配置した場合)
  // __DIR__ は現在のファイルのディレクトリを指します。
  // lib フォルダが contactform.php と同じ階層にあることを前提としています。
  require_once __DIR__ . '/lib/Exception.php';
  require_once __DIR__ . '/lib/PHPMailer.php';
  require_once __DIR__ . '/lib/SMTP.php';

  if( isset($_POST['back']) && $_POST['back'] ){
    // When the back button is pressed, just stay in input mode
  } else if( isset($_POST['confirm']) && $_POST['confirm'] ){
    // --- Validation ---
    if( !isset($_POST['fullname']) || trim($_POST['fullname']) === '' ) {
        $errors[] = "お名前を入力してください";
    }
    if( !isset($_POST['email']) || trim($_POST['email']) === '' ) {
        $errors[] = "Eメールアドレスを入力してください";
    }
    if( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
        $errors[] = "正しい形式のEメールアドレスを入力してください";
    }
    if( !isset($_POST['message']) || trim($_POST['message']) === '' ) {
        $errors[] = "お問い合わせ内容を入力してください";
    }

    // --- Set Session and Mode ---
    if ( empty($errors) ) {
        $_SESSION['fullname'] = $_POST['fullname'];
        $_SESSION['email']    = $_POST['email'];
        $_SESSION['message']  = $_POST['message'];
        $mode = 'confirm';
    } else {
        // If there are errors, stay in input mode to show them
        $_SESSION['fullname'] = $_POST['fullname'] ?? '';
        $_SESSION['email']    = $_POST['email'] ?? '';
        $_SESSION['message']  = $_POST['message'] ?? '';
        $mode = 'input';
    }

  } else if( isset($_POST['send']) && $_POST['send'] ){
    $mail = new PHPMailer(true); // 例外を有効にする

    try {
        //サーバー設定
        $mail->isSMTP();                                            // SMTPを使用
        $mail->Host       = 'sv16067.xserver.jp';                       // SMTPサーバーのホスト名 (例: smtp.gmail.com)
        $mail->SMTPAuth   = true;                                   // SMTP認証を有効にする
        $mail->Username   = 'info@m-asoka-kai.jp';                   // SMTPユーザー名 (例: your-email@example.com)
        $mail->Password   = '88YpH%:B9d7X';                   // SMTPパスワード (Gmailの場合はアプリパスワード)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // SSL/TLS暗号化を有効にする (tls も可)
        $mail->Port       = 465;                                    // TCPポート (SSL:465, TLS:587)

        //文字コード設定
        $mail->CharSet = 'UTF-8';

        //受信者
        // setFrom() の第一引数は、SMTP認証で使うメールアドレスと同じにするのが最も安全です。
        // フォームに入力されたユーザーのメールアドレスは Reply-To に設定します。
        $mail->setFrom('info@m-asoka-kai.jp', 'ウェブサイトお問い合わせ'); // 送信元として表示したいメールアドレスと名前
        $mail->addAddress('akaginosou@nifty.com', 'お問い合わせ');     // 受信者 (akaginosou@nifty.com)
        $mail->addReplyTo($_SESSION['email'], $_SESSION['fullname']); // 返信先をフォーム入力者のメールアドレスに設定

        //コンテンツ
        $mail->isHTML(false);                                       // HTMLメールではない (テキストメール)
        $mail->Subject = 'ウェブサイトからのお問い合わせ';
        $mail->Body    = "名前: " . $_SESSION['fullname'] . "\n"
                       . "Eメール: " . $_SESSION['email'] . "\n"
                       . "お問い合わせ内容:\n" . $_SESSION['message'];

        $mail->send();
        $mode = 'send';
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        session_destroy();
    } catch (Exception $e) {
        $mode = 'error';
        // エラー情報をログに出力 (サーバーのエラーログで確認できます)
        error_log("お問い合わせメールの送信に失敗しました。Mailer Error: {$mail->ErrorInfo}");
    }
  } else {
    $_SESSION['fullname'] = "";
    $_SESSION['email']    = "";
    $_SESSION['message']  = "";
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせ - 社会福祉法人前橋あそか会</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:700,400">
  <link rel="stylesheet" href="css/style.css"> 
  <style>
    body {
        background-color: #f5f5f5;
        color: #333;
    }
    .contact-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        text-align: left;
    }
    .contact-container h1 {
        text-align: center;
        color: #FC9624;
        font-family: "メイリオ", sans-serif;
        font-size: 3.5rem;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 1.6rem;
        margin-bottom: 8px;
        color: #555;
    }
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        font-size: 1.6rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 150px;
    }
    .form-actions {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin-top: 30px;
    }
    .btn {
        padding: 12px 25px;
        font-size: 1.6rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
        color: #fff;
        text-align: center;
    }
    .btn-primary {
        background-color: #FC9624;
        flex-grow: 1;
    }
    .btn-primary:hover {
        background-color: #e08520;
    }
    .btn-secondary {
        background-color: #aaa;
    }
    .btn-secondary:hover {
        background-color: #888;
    }
    .confirmation-area, .completion-message {
        font-size: 1.6rem;
        line-height: 1.8;
    }
    .confirmation-area strong {
        display: block;
        color: #555;
        margin-bottom: 5px;
    }
    .confirmation-area div {
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 4px;
        margin-bottom: 15px;
        white-space: pre-wrap; /* To respect newlines */
        word-wrap: break-word;
    }
    .error-messages {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #c62828;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .error-messages ul {
        margin: 0;
        padding-left: 20px;
    }
    .home-link {
        display: inline-block;
        margin-top: 20px;
        color: #FC9624;
        text-decoration: none;
        font-size: 1.6rem;
    }
    .home-link:hover {
        text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="contact-container">
    <?php if( $mode == 'input' ) { ?>
      <h1>お問い合わせ</h1>
      <?php if (!empty($errors)): ?>
        <div class="error-messages">
          <ul>
            <?php foreach($errors as $error): ?>
              <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <form action="./contactform.php" method="post">
        <div class="form-group">
          <label for="fullname">お名前</label>
          <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($_SESSION['fullname']) ?>" required>
        </div>
        <div class="form-group">
          <label for="email">Eメール</label>
          <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']) ?>" required>
        </div>
        <div class="form-group">
          <label for="message">お問い合わせ内容（営業に関するお問い合わせには、ご対応いたしかねますことをご了承ください）</label>
          <textarea id="message" name="message" required><?php echo htmlspecialchars($_SESSION['message']) ?></textarea>
        </div> 
        <div class="form-actions">
            <a href="index.html" class="btn btn-secondary">ホームに戻る</a>
            <input type="submit" name="confirm" value="入力内容の確認" class="btn btn-primary"/>
        </div>
      </form>

    <?php } else if ( $mode == 'confirm' ){ ?>
      <h1>入力内容の確認</h1>
      <form action="./contactform.php" method="post" class="confirmation-area">
        <strong>お名前</strong>
        <div><?php echo htmlspecialchars($_SESSION['fullname']) ?></div>
        <strong>Eメール</strong>
        <div><?php echo htmlspecialchars($_SESSION['email']) ?></div>
        <strong>お問い合わせ内容</strong>
        <div><?php echo nl2br(htmlspecialchars($_SESSION['message'])) ?></div>
        <div class="form-actions">
          <input type="submit" name="back" value="修正する" class="btn btn-secondary"/>
          <input type="submit" name="send" value="この内容で送信する" class="btn btn-primary"/>
        </div>
      </form>

    <?php } else if ( $mode == 'send' ){
      ?>
      <div class="completion-message">
        <h1>送信完了</h1>
        <p>お問い合わせいただき、誠にありがとうございます。内容を確認の上、担当者よりご連絡させていただきます。</p>
        <p>通常、数営業日以内にご返信いたしますので、今しばらくお待ちください。</p>
        <a href="./index.html" class="home-link">ホームに戻る</a>
      </div>

    <?php } else if ( $mode == 'error' ){
      ?>
      <div class="completion-message">
        <h1>送信エラー</h1>
        <p>申し訳ございません。メールの送信に失敗しました。</p>
        <p>お手数ですが、時間をおいて再度お試しいただくか、別のご連絡手段をご利用ください。</p>
        <a href="./contactform.php" class="home-link">もう一度試す</a>
      </div>
    <?php } ?>
  </div>

</body>
</html>