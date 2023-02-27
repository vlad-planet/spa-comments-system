/* Компонент VueJS Раздела Комментарии*/
let comn = new Vue({
	el: '#comments',
	data: {
		
		items:  [],
		errors: [],
		status: {},
		
		// Свойства комментариев
		comments: {
			name:  '',
			email: '',
			title: '',
			text:  ''
		}
	},
	
	// Автозапуск
	mounted: function() {
		this.showComments();
	},
	
	// Методы для обработки данных
    methods: {
        sendIdentity: function() {
			
            let personForm = comn.toFormData(comn.comments);

				// Ajax запрос на добавление коминтариев
				axios.post('/comments/create', personForm)
					.then(function(response) {
						
						comn.errors = [];
						
						// В случае успеха отобразить комментарий в списке
						if (!response.data.error) {

							comn.items.unshift(comn.comments);
							comn.comments = {};
							comn.errors.unshift({message: 'Comment posted Successfully.'});
							comn.status = 'text-success';
						
						// Иначе вывести информацию обработчика полей
						} else {
							err = response.data.message;

							Object.entries(err).forEach(function(entry) {
								comn.errors.unshift({message: entry[1]});
							});
							comn.status = 'text-danger';
						}
                })
        },
		
		// Получить данные из формы добавление коминтариев
        toFormData: function(obj) {
            let formData = new FormData();
			
            for(let key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },

		// Отображение уже созданных коминтариев
		showComments: function() {
			axios.get('/comments/ajax')
				.then( function(response) {
					comn.items = response.data;
				})
        }
    }
});