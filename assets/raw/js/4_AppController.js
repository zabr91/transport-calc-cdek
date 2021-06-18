/**
 * CDEK Frontend controller
 */
jQuery(function ($) {

    $(document).ready(function () {


        class AppController {

            // calculator = document.getElementById('calculator');

            calculatorForIndex;
            calculatorForIndexAddPlace;
            calculatorForIndexPlaces;

            goods = [];

            constructor() {

                this.calculatorForIndex = document.getElementById('calculatorForIndex')

                if(!this.calculatorForIndex)
                {
                    return 0;
                }


                this.calculatorForIndexAddPlace = calculatorForIndex.querySelector('#calculatorForIndex-addPlace')
                this.calculatorForIndexPlaces = calculatorForIndex.querySelector('#calculatorForIndex-places')

                $('[data-toggle="tooltip"]').tooltip();

                AppController.autocomplete('#calculatorForIndex [name=senderCity]', '#calculatorForIndex [name=senderCityId]')
                AppController.autocomplete('#calculatorForIndex [name=receiverCity]', '#calculatorForIndex [name=receiverCityId]')

                this.calculatorForIndexAddPlace.addEventListener('click', e => {
                    e.preventDefault();
                    this.addPlace();
                });

                this.calculatorForIndexPlaces.addEventListener('click', e => {
                    e.preventDefault();
                    this.indexPlaces(e);
                });

                this.calculatorForIndex.addEventListener('submit', async e => {
                    e.preventDefault();

                    await this.sendData(this.calculatorForIndex);
                });

                /*$('.calculatorForIndex-contact-form').on('click', e => {

                });*/

                $('#table').on('click', '.calculatorForIndex-contact-form', function(e){
                    e.preventDefault();
                    $("#modalform").modal('show');
                });


            }

            /**
             * Autocomplete city names
             * @param inputSelector
             * @param outputSelector
             */
            static autocomplete(inputSelector, outputSelector) {
                $(inputSelector).autocomplete({
                    source: (request, response) => AppModel.getListByTerm(inputSelector, response),
                    minLength: 1,
                    select: (event, ui) => $(outputSelector).val(ui.item.id)
                })
            }


            /**
             * Indexing places
             */
            indexPlaces(e) {
                this.goods = this.goods.filter((_, index) => index != e.target.offsetParent.dataset.key);

                const calculatorForIndexPlaces = calculatorForIndex.querySelector('#calculatorForIndex-places');
                calculatorForIndexPlaces.innerHTML = '';

                for (const [key, item] of Object.entries(this.goods)) {
                    calculatorForIndexPlaces.innerHTML += `
				<li class="list-group-item border-success" data-key="${key}">
					${item.weight} кг ${item.length}&times;${item.width}&times;${item.height} см
					<button class="close">
						<span class="text-success">&times;</span>
					</button>
					<input name="goods[${key}][weight]" value="${item.weight}" hidden>
					<input name="goods[${key}][length]" value="${item.length}" hidden>
					<input name="goods[${key}][width]" value="${item.width}" hidden>
					<input name="goods[${key}][height]" value="${item.height}" hidden>
				</li>
			`;
                }
            }


            /**
             * Add new delivery place
             */
            addPlace() {
                try {
                    const calculatorForIndexWeightFake = this.calculatorForIndex.querySelector('[name=_weight]');
                    const calculatorForIndexLengthFake = this.calculatorForIndex.querySelector('[name=_length]');
                    const calculatorForIndexWidthFake = this.calculatorForIndex.querySelector('[name=_width]');
                    const calculatorForIndexHeightFake = this.calculatorForIndex.querySelector('[name=_height]');

                    const weight = +calculatorForIndexWeightFake.value || 0;
                    const length = +calculatorForIndexLengthFake.value || 0;
                    const width = +calculatorForIndexWidthFake.value || 0;
                    const height = +calculatorForIndexHeightFake.value || 0;

                    if (!weight) {
                        throw new Error('Заполните вес!');
                    }

                    if (!length) {
                        throw new Error('Заполните длину!');
                    }

                    if (!width) {
                        throw new Error('Заполните ширину!');
                    }

                    if (!height) {
                        throw new Error('Заполните высоту!');
                    }

                    this.goods = [...this.goods, {weight, length, width, height}];

                    const calculatorForIndexPlaces = calculatorForIndex.querySelector('#calculatorForIndex-places');
                    calculatorForIndexPlaces.innerHTML = '';

                    for (const [key, item] of Object.entries(this.goods)) {
                        calculatorForIndexPlaces.innerHTML += `
					<li class="list-group-item border-success" data-key="${key}">
						${item.weight} кг ${item.length}&times;${item.width}&times;${item.height} см
						<button class="close">
							<span class="text-success">&times;</span>
						</button>
						<input name="goods[${key}][weight]" value="${item.weight}" hidden>
						<input name="goods[${key}][length]" value="${item.length}" hidden>
						<input name="goods[${key}][width]" value="${item.width}" hidden>
						<input name="goods[${key}][height]" value="${item.height}" hidden>
					</li>
				`;
                    }
                } catch (e) {
                    this.sendMessage(e.message, true);
                }
            }

            async sendData(calculatorForIndex) {

                const preloader = document.getElementById('preloader');

               // try{
                const senderCityId = calculatorForIndex.querySelector('[name=senderCityId]').value;
                const receiverCityId = calculatorForIndex.querySelector('[name=receiverCityId]').value;

                if (!senderCityId) {
                    const calculatorForIndexSenderCity = calculatorForIndex.querySelector('[name=senderCity]');
                    calculatorForIndexSenderCity.value = '';
                    throw new Error('Введите город отправителя!');
                }

                if (!receiverCityId) {
                    const calculatorForIndexReceiverCity = calculatorForIndex.querySelector('[name=receiverCity]');
                    calculatorForIndexReceiverCity.value = '';
                    throw new Error('Введите город получателя!');
                }

                console.log("goods " + this.goods.length)

                if (this.goods.length) {

                    console.log("goods in if")
                    //    preloader.classList.add('preloader_active');
                    let button = calculatorForIndex.querySelector('[type=submit]');
                    button.outerHTML = `
					<button type="submit" class="btn btn-success w-100" disabled>
						<span class="spinner-border spinner-border-sm"></span>
						Загрузка...
					</button>
				`;

                    const formData = new FormData(calculatorForIndex);
                    const formDataArr = [];

                    for (let [name, value] of formData) {
                        formDataArr[name] = value;
                    }
                    /*
                                    new ISDEKWidjet({
                                        defaultCity: formDataArr['receiverCity'].split(',')[0] || 'Санкт-Петербург', // какой город отображается по умолчанию
                                        cityFrom: formDataArr['senderCity'].split(',')[0] || 'Москва', // из какого города будет идти доставка
                                        country: 'Россия', // можно выбрать страну, для которой отображать список ПВЗ
                                        link: 'forpvz', // id элемента страницы, в который будет вписан виджет
                                        path: 'https://widget.cdek.ru/widget/scripts/', // директория с библиотеками виджета
                                        servicepath: 'service.php', // ссылка на файл service.php на вашем сайте
                                        apikey: '479d1287-1793-46b5-932d-07fed6a84183', // ключ для корректной работы Яндекс.Карт, получить необходимо тут
                                        goods,
                                    });
                    */

                    const response = AppModel.getTablePrice(formData);

                    console.log('Response: '+response)

                    if (response) {
                        const data = JSON.parse(response);

                        const weight = this.goods.reduce((weight, item) => weight + item.weight, 0);
                        const volume = this.goods.reduce((length, item) => length + item.length, 0)
                            * this.goods.reduce((width, item) => width + item.width, 0)
                            * this.goods.reduce((height, item) => height + item.height, 0)
                            / 10000000;
                        const volumeWeight = this.goods.reduce((volumeWeight, item) => volumeWeight + (item.length * item.width * item.height / 5000), 0);


                        AppView.table(formDataArr, weight, volume, volumeWeight, data);

                    }
                }

                /*  }
                  catch (e) {
                      this.sendMessage(e.message, true);
                  }*/

            }


            /**
             * Send message for user
             * @param message input message
             * @param error bool
             */
            sendMessage(message, error) {
                const modalMessageBody = document.getElementById('modalMessage-body')

                modalMessageBody.innerHTML = `
			<button class="close" data-dismiss="modal">
			  <span class="text-success">&times;</span>
			</button>
		`

                if (error) {
                    modalMessageBody.innerHTML += `
				<div class="text-danger h1">${message}</div>
			`
                } else {
                    modalMessageBody.innerHTML += `
				<div class="text-success h1">${message}</div>
			`
                }

                $("#modalMessage").modal('show')
            }

        }

        /**
         * Start app
         */
        let app = new AppController();


