<?php
/*
 * Global lang file
 * This file was generated automatically from messages.po
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

$trans['ru_RU'] = array(
'__meta__' => array('format_version'=>1, 'charset'=>'utf-8'),
'' => "Project-Id-Version: Feed Importer Pro plugin v1.0\nReport-Msgid-Bugs-To: http://fplanque.net/\nPOT-Creation-Date: 2010-01-04 01:45-0500\nPO-Revision-Date: 2010-01-04 01:50-0500\nLast-Translator: Alex\nLanguage-Team: Russian b2evolution\nMIME-Version: 1.0\nContent-Type: text/plain; charset=UTF-8\nContent-Transfer-Encoding: 8bit\nX-Poedit-Language: Russian\nX-Poedit-Country: RUSSIAN FEDERATION\n",
'Creates posts from different sources.' => 'Создает записи из различных источников.',
'This plugin allows you to import posts from different sources such as XML feeds, b2evo backup files (*.b2e), and plain text files. It also creates b2evo backup files (*.b2e).' => 'Этот плагин позволяет импортировать записи из различных источников, таких как: XML ленты, b2evo backup файлы (*.b2e )и CSV файлы. Он также создает b2evo backup файлы (*.b2e ).',
'Recent feeds list' => 'Недавние ленты',
'Check this if you want to display a list or recently used XML feeds.' => 'Отметьте, если хотите отображать список недавно импортированных XML лент.',
'Asynchronous outbound pings' => 'Асинхронный пинг',
'Check this if you want to enable scheduled outbound pings.' => 'Включить отправку пингов по расписанию.',
'NOTE: make sure that your scheduled jobs are properly set up.' => 'Обратите внимание, что для работы этой функции, назначенные задания должны быть корректно настроены.',
'Scheduled import' => 'Импорт по расписанию',
'Check this if you want to enable scheduled XML feed import.' => 'Отметьте, если хотите использовать импорт по расписанию',
'Published (Public)' => 'Опубликован (Публичный)',
'Draft (Not published!)' => 'Черновик (Не опубликован!)',
'Posts status' => 'Статус записей',
'Select the status for imported posts.' => 'Выберите статус для импортируемых записей.',
'Limit' => 'Число записей',
'Enter the number of items to import. Leave empty to import all available items.' => 'Введите число импортируемых записей. Оставьте пустым чтобы импортировать все доступные.',
'Post header' => 'В начало записи',
'Enter post header text here. This text will be added to the top of each post.' => 'Введите текст, который будет помещен над каждой опубликованной записью.',
'Post footer' => 'В конец записи',
'Enter post footer text here. This text will be added to the bottom of each post.' => 'Введите текст, который будет помещен под каждой опубликованной записью.',
'The following tags will be replaced with the real values when <b>XML Feed</b> is imported: %s' => 'Следующие теги будут заменены их реальными значениями, при импорте <b>XML лент</b>: %s',
'Example: Read original article %s on %s.' => 'Пример: Оригинал этой записи %s в ленте %s.',
'You must select a main category' => 'Вы должны выбрать основную рубрику для импорта записей',
'Import new posts from XML feeds' => 'Импорт записей из XML лент',
'Scheduled XML feed import is disabled in plugin settings' => 'Импорт по расписанию отключен в настройках плагина',
'Checking the feed for new posts' => 'Проверям ленту на наличие новых записей',
'No XML feeds found in the database!' => 'XML ленты не найдены в базе данных!',
'Back to Import/Export tab' => 'Назад на страницу Импорта/Экспорта',
'Manage XML feeds' => 'Уаправление XML лентами',
'Saved XML feeds' => 'Сохраненные XML ленты',
'The feed is disabled.' => 'Лента отключена',
'The feed is enabled.' => 'Лента включена',
'En' => 'Вкл',
'Title' => 'Заголовок',
'URL' => 'URL',
'Open in new window' => 'Открыть в новом окне',
'Date Time' => 'Дата',
'Enable' => 'Включить',
'Disable' => 'Отключить',
'Delete' => 'Удалить',
'Do you really want to delete this feed?' => 'Вы действительно хотите удалить эту ленту?',
'Actions' => 'Действия',
'Export' => 'Экспорт',
'Select a blog' => 'Выберите блог',
'Export all items from selected blog in *.b2e format.' => 'Экспортировать все записи из выбранного блога в формате *.b2e',
'Export !' => 'Экспорт !',
'No blogs avaliable for export yet.' => 'Нет доступных для экспорта блогов.',
'Import' => 'Импорт',
'Select a blog where you want to import posts.' => 'Выберите блог для импорта записей.',
'Continue...' => 'Продолжить...',
'None' => 'Нет',
'Select a feed you already used or enter new address below.' => 'Выберите сохраненную XML ленту или введите новый адрес ниже.',
'Address' => 'Адрес',
'Enter either remote (URL) or local (file path) address.' => 'Введите удаленный (URL) или локальный (путь к файлу) адрес.',
'Import type' => 'Тип импорта',
'What do you want to import?' => 'Что вы собираетесь импортировать?',
'Check post existance' => 'Проверка существования записей',
'Should we skip imported items if they already exist in the database.' => 'Должны ли мы пропускать уже существующие записи и добавлять только новые или измененные.',
'Import comments' => 'Импортировать комментарии',
'Should we import post comments, trackbacks etc. (<b>*.b2e import type only</b>).' => 'Должны ли мы импортировать комментарии, трекбеки и т.д. (<b>только для *.b2e файлов</b>).',
'Import !' => 'Импорт !',
'Do you really want to continue?' => 'Вы действительно хотите продолжить?',
'The feed has been enabled!' => 'Лента была включена!',
'The feed has been disabled!' => 'Лента была отключена!',
'The feed has been deleted!' => 'Лента была удалена!',
'Exported file zipped' => 'Экспортируемый файл заархивирован',
'The address field is empty.' => 'Пустая строка адреса.',
'Feed not found.' => 'XML лента не найдена.',
'Invalid data supplied in %s' => 'Ошибка при чтении данных из %s',
'The post %s already exists in DB, skipping...' => 'Запись %s уже существует, пропускаем...',
'Permission denied.' => 'Доступ запрещен.',
'Invalid post title: %s' => 'Ошибка в заголовке записи: %s',
'Invalid post content' => 'Ошибка в содержании записи',
'New post created:' => 'Создана новая запись:',
'Send notifications for &laquo;%s&raquo;' => 'Отправка уведомлений для &laquo;%s&raquo;',
'Unable to create a post' => 'Не удалось создать запись',
'and %d comments imported.' => ', а также %d комментариев.',
'Blog not found' => 'Блог не найден',
'You\'re not allowed to view this page!' => 'У вас нет прав на просмотр этой страницы!',
'Unable to create directory for exported files, contact the admin.' => 'Не удалось создать директорию для экспортируемых файлов, свяжитесь с администратором системы.',
'You must create the following directory with write permissions (777):%s' => 'Вы должны создать следующую директорию с разрешениями на запись (777):%s',
'Cannot create <i>.htaccess</i> file!' => 'Не удалось создать <i>.htaccess</i> файл!',
'Make sure the directory [%s] has write permissions (777)' => 'Убедитесь что директория [%s] имеет разрешения на запись (777)',
'Unable to read data from %s' => 'Не удалось получить данные из %s',
'Unable to create CSV file.' => 'Не удалось создать CSV файл.',
'Blog #%d exported' => 'Блог #%d экспортирован',
'Sorry, you have no permission to post yet. The Import feature is unavaliable.' => 'Извините, у вас нет прав на запись. Импорт записей невозможен.',
'Categories for blog "%s"' => 'Рубрики блога "%s"',

);
?>