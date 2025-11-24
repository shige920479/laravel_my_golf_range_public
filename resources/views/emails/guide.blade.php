<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>本登録のご案内</title>
    <style>
      #mail-header {
        margin-top: 40px;
        margin-bottom: 25px;
      }
      #mail-header h1 {
        font-size: 1.4rem;
        margin-bottom: 30px;
      }
      #mail-header h2 {
        font-size: 1rem;
      }
      #mail-header h2 span {
        font-size: 0.9rem;
        font-weight: normal;
      }
      #mail-header p {
        font-size: 0.9rem;
      }
      #mail-content p {
        line-height: 2;
      }
      #mail-content p {
        line-height: 2;
      }
      #mail-content p a {
        color: blue;
        text-decoration: underline;
      }
      #mail-content p:nth-child(1),
      #mail-content p:nth-child(4),
      #mail-content p:nth-child(5) {
        margin-bottom: 20px;
      }
    </style>
  </head>
  <body>
    <div class="wrapper temp-register-email">
      <div id="mail-header">
        <h1>[MY_GOLF_RANGE]会員登録のご確認</h1>
        <h2>MY_GOLF_RANGE<span>&lt;owner@example.com&gt;</span></h2>
        <p>To 自分</p>
      </div>
      <div id="mail-content">
        <p>※本メールは自動配信メールです</p>
        <p>仮登録有難うございます</p>
        <p>登録はまだ完了しておりません。</p>
        <p>下記URLにアクセスし、会員登録を進めてください。</p>
        <p>
          <a href="{{ $url }}">会員登録ページへのリンクURL</a>
        </p>
        <p>24時間経過するとURLは無効となります。</p>
        <p>24時間経過後ははじめからお手続きください。</p>
      </div>
    </div>
  </body>
</html>