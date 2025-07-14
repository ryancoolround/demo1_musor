<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Профессиональный вывоз мусора, старой мебели, демонтаж и уборка в Туле. Надёжно, быстро и недорого." />
  <meta name="keywords" content="вывоз мусора, демонтаж, уборка гаражей, Тула" />
  <title>Вывоз мусора в Туле – быстро и недорого</title>
  <link rel="icon" type="image/png" href="/demo1/faviconmusor.png" />
  <link rel='stylesheet' href="/demo1/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;900&display=swap" rel="stylesheet" />
</head>
<body>

<?php
if (isset($_SESSION['form_status'])) {
    $status = $_SESSION['form_status'];
    unset($_SESSION['form_status']);
    ?>
    <div id="status-alert" style="
      background-color: <?= $status['success'] ? '#d4edda' : '#f8d7da' ?>;
      color: <?= $status['success'] ? '#155724' : '#721c24' ?>;
      border: 1px solid <?= $status['success'] ? '#c3e6cb' : '#f5c6cb' ?>;
      padding: 15px;
      margin: 15px auto;
      max-width: 600px;
      border-radius: 4px;
      font-weight: bold;
      text-align: center;
      transition: opacity 0.5s ease;
    " role="alert">
      <?= htmlspecialchars($status['message']) ?>
    </div>
<?php
}
?>

<header>
  <h1>Вывоз мусора в Туле</h1>
  <nav>
    <a href="#uslugi">Услуги</a>
    <a href="#calc">Калькулятор</a>
    <a href="#contact">Контакты</a>
  </nav>
</header>

<section style="background-color: #ffcc00; color: #000; text-align: center; padding: 10px; font-weight: bold;">
  Внимание! Это демонстрационная страница, созданная для примера. Реальных услуг не предоставляет.
</section>

<section class="hero" aria-label="Главный призыв к действию">
  <h2>Быстро и надёжно вывезем мусор и старую мебель</h2>
  <p>Работаем без выходных. Цены от 1500 ₽. Чистота и порядок — с нами просто!</p>
  <button onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Оставить заявку</button>
</section>

<section id="uslugi" aria-label="Услуги компании">
  <h2>Наши услуги</h2>
  <ul>
    <li>Вывоз строительного мусора</li>
    <li>Вывоз старой мебели</li>
    <li>Демонтаж конструкций</li>
    <li>Уборка гаражей и подвалов</li>
    <li>Утилизация бытовой техники</li>
  </ul>
</section>

<section id="calc" aria-label="Калькулятор стоимости">
  <h2>Калькулятор стоимости</h2>
  <form id="calcForm" onsubmit="return false;">
    <label for="service">Тип услуги
      <select id="service" name="service" required>
        <option value="mebel">Вывоз мебели</option>
        <option value="musor">Вывоз мусора</option>
        <option value="demontazh">Демонтаж</option>
      </select>
    </label>
    <label for="volume">Объём (м³ или количество мешков)
      <input id="volume" type="number" name="volume" min="0" step="0.1" placeholder="Например, 3" required />
    </label>
    <label for="floor">Этаж (если без лифта)
      <input id="floor" type="number" name="floor" min="0" step="1" placeholder="Например, 2" />
    </label>
    <button class="calc-btn" type="submit" onclick="calculate()">Рассчитать</button>
    <p class="result" id="result"></p>
  </form>
</section>

<section id="contact" aria-label="Форма заявки">
  <h2>Оставить заявку</h2>
  <form action="send.php" method="POST" novalidate>
    <input type="text" name="name" placeholder="Ваше имя" required autocomplete="name" />
    <input type="tel" name="phone" placeholder="Телефон" required autocomplete="tel" pattern="\+?\d{7,15}" title="Введите корректный телефон" />
    <textarea name="comment" placeholder="Комментарий (по желанию)"></textarea>
    <button type="submit">Отправить</button>
  </form>
</section>

<footer>
  <p>© 2025 Вывоз Мусора | г. Тула | Все права защищены</p>
</footer>

<script>
  function calculate() {
    const volume = parseFloat(document.getElementById('volume').value) || 0;
    const floor = parseInt(document.getElementById('floor').value) || 0;
    const basePrice = 1500;
    const volumePrice = volume * 500;
    const floorPrice = floor * 100;
    const total = basePrice + volumePrice + floorPrice;
    const resultEl = document.getElementById('result');
    resultEl.textContent = `Итого: ${total.toLocaleString('ru-RU')} ₽`;
  }

  // Автоматическое скрытие уведомления
  window.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('status-alert');
    if (alert) {
      setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 600);
      }, 6000);
    }
  });
</script>

</body>
</html>