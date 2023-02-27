const Comments = {

	/** Объекты */
	ajax: null,

	/** Селекторы */
	selectors: {
		form:   '#commentForm',
		show: 	'#showComments',
		msg: 	'#text-message'
	},

	/** Сообщения */
	messages: {
		success: 'Comment posted Successfully.',
		error:   'Error: Comment not posted. ++'
	},

	/** Методы */
	methods: {
		/**
		 * функция для отображения добавленных комментариев
		 */
		showComments()	{

			Comments.ajax = $.ajax({

				url: "/comments/items",
				method: "POST",

				success:function(response) {
					$(Comments.selectors.show).html(response);
				}

			}).always(function () {
				Comments.ajax = null;
			});
		}

	},

	/** Обработчики */
	handlers() {
		/**
		 * Отпраить данные на добавление коментария
		 */
		$(Comments.selectors.form).on('submit', function(event) {

			event.preventDefault();
			formData = $(this).serialize();

			Comments.ajax = $.ajax({

				url: "/comments/create",
				method: "POST",
				data: formData,
				dataType: "JSON",

				success: function(response) {
					
					if(!response.error) {
						
						$(Comments.selectors.form)[0].reset();
						$(Comments.selectors.msg).html(Comments.messages.success);
						$(Comments.selectors.msg).attr('class','text-success');
						
						Comments.methods.showComments();
					}else{
						
						msg = '';
						Object.entries(response.message).forEach(function(entry) {							
						msg += entry[1] + "<br>"; });

						$(Comments.selectors.msg).html(msg);
						$(Comments.selectors.msg).attr('class','text-danger');
					}
				},

				error: function() {
					$(Comments.selectors.msg).html(Comments.messages.error);
				}

			}).always(function () {
				Comments.ajax = null;
			});
		});
	},

	/** Инициализация */
	init() {
		Comments.handlers();
	}
}

$(document).ready(function () {
	Comments.init();
});