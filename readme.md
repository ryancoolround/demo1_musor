# 💼 Демонстрационный лендинг "Вывоз мусора в Туле"

Данный проект представляет собой **демо-версию одностраничного лендинга** по вывозу мусора, старой мебели, демонтажу и уборке. Это пример веб-сайта, который можно адаптировать под реальные услуги.

## 🧾 Описание

Сайт создан как демонстрация возможностей простого и адаптивного лендинга с калькулятором стоимости и формой обратной связи. Реальные услуги **не предоставляются**. Сайт можно использовать как шаблон для аналогичных проектов.

## ⚙️ Функциональность

- ✅ Одностраничный лендинг (SPA)
- ✅ SEO-настройки (`title`, `description`, `keywords`, favicon)
- ✅ Навигация по якорям
- ✅ Форма заявки (отправка через `send.php`)
- ✅ Калькулятор стоимости с учётом:
  - типа услуги
  - объёма (м³ или мешков)
  - этажа (если без лифта)
- ✅ Адаптивный дизайн
- ✅ Уведомления о статусе заявки (сессии `$_SESSION['form_status']`)
- ✅ Лёгкий вес страницы (~84 KB)

## 📂 Структура проекта
/
├── index.php                  # Главная страница лендинга
├── send.php                   # Скрипт обработки формы (реализуется отдельно)
├── /css/style.css             # Стили оформления
├── /faviconmusor.png          # Иконка сайта
└── /demo1/                    # (опциональная директория, если размещён в подкаталоге)

## 🖥️ Технологии

- 💻 **PHP** — обработка формы, сессии
- 🧾 **HTML5** — разметка
- 🎨 **CSS3** — оформление (подключено внешне)
- 🔢 **Vanilla JS** — калькулятор стоимости, динамика
- 🔤 **Google Fonts (Montserrat)** — шрифт

## 🚀 Установка и запуск

1. **Скопируйте файлы на ваш сервер:**

   ```bash
   git clone https://github.com/ryancoolround/demo1_musor.git
   ```

2. **Убедитесь, что на сервере включена поддержка PHP.**

3. **Настройте `send.php` для обработки формы (отправка email.)**

4. **Откройте `index.php` в браузере:**

   ```
   http://your-domain.com/index.php
   ```

## ⚠️ Дисклеймер

> Сайт **не предоставляет реальных услуг**. Это демонстрационная страница, предназначенная для показа клиенту, отладки функционала или создания шаблонов.