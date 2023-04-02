Вам предлагается выполнить тестовое задание. 

# Цель теста

Задание выбрано достаточно простое. Цель теста -- оценить 
то, как вы строите структуру приложения, как оформляете код, 
насколько внимательно читаете требования задания и проверяете 
свой код на ошибки. 

Тестовое задание не оплачивается.

Задание написано по английски, поскольку большинство наших 
спецификаций также написаны на этом языке и умение читать 
технический английский текст является обязательным требованием.

# Test task

Please build simple TODO app with optimistic record locking. 

## Todo item fields

* title (text, mandatory)
* priority (integer default 0)
* done (boolean default false)

## Frontend

Please create CRUD set of pages (or single page application) for TODO items and an API endpoint to mark items as done/not done.

### Items list page

Items should be ordered by priority (DESC). Table should include all fields. 

### Add/Edit page

All fields are editable. Title is a textarea, mandatory (should be nonempty), empty by default. Priority is integer, 0 by default, mandatory. Done is a checkbox, off by default. 

Buttons: [Save], [Cancel], and [Delete]

## Optimistic locking

Concurrent editing should be prevented using optimistic locking by version field. It is important to use version field, not just comparing old vs new data. If user A opens edit page for an item, then another user B modifies item and saves it, and then user A clicks save, then following message should appear "Conflict, item was changed by another user, your changes will be lost. [Edit again] [Cancel]". ([Edit again] and [Cancel] are buttons, [Edit again] should reload form with current data from the database, and [Cancel] should return user to the homepage)

## API access to the DONE field

A single API endpoint should be exposed to mark items as done/not done by ID. Please use RESTful convention for endpoint address, parameters and payload. 

Optimistic locking should not be applied to this API endpoint: if user A opens item for editing, then API call is made to mark this item as done, then user A clicks save (done checkbox is off on the form), no error message should appear, item should be saved, item's done status should be reset to false. 

API endpoint should be open to everyone and should not have any authentication or API key verification. 

# Требования к программному обеспечению

Apache 2.x, PHP 7.x, MySQL 5.x или 8.x

# Требования к исходным текстам

Используйте Yii2. Возможно использование кодогенератора для всего чего сочтете уместным - на ваше усмотрение. Возможно так же использование готовых демо приложений TODO на Yii2.

Можно использовать сторонние библиотеки. Можно также использовать 
собственные библиотеки, если вы уверены в их качестве.

Мы уделяем большое внимание качеству. Если вы при выполнении теста
используете какую-либо методику, направленную на повышение качества кода, 
например написание автоматизированных тестов, это будет несомненный плюс, 
хотя не является обязательным требованием для данного задания.

# Требования к выдаче результатов

В результате выполнения теста я расчитываю получить от вас 
работоспособное приложение. Все необходимые файлы и структуру 
каталогов запакуйте в ZIP-архив. Напишите краткую инструкцию по 
установке. Сторонние библиотеки лучше включать в архив с кодом (если нет возможности - то 
включите в инструкцию по установке URL, откуда их можно скачать.)
Вышлите архив на адрес: info@idevelopernetwork.com. Тема письма: 
"PHP Developer Test".

Результаты выполнения теста желательно прислать в течение 3-х дней с 
момента выдачи задания.

# Критерии оценки

Результат выполнения тестового задания оценивается по следующим 
критериям:

- Выполнение всех требований задания
- Комплектность исходных текстов
- Качество кода
- Стиль программирования
- Оформление результатов тестового задания
- Время выполнения теста

Если в процессе выполнения теста у вас возникли неясности и 
вопросы - пишите в чат, или же вы можете сделать допущения (укажите их в 
сопроводительном письме или в инструкции). 

