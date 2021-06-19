<div class="d-flex flex-column">
    <section class="py-1 order-3 order-md-1" id="section-calculator">
        <div class="container">
            <h2 class="mb-4 text-uppercase">
                <span class="text-success">Калькулятор</span>
                для юридических лиц
            </h2>
            <!-- <div class="textlogo">Калькулятор для юридических лиц</div> -->
            <div class="row">
                <div class="col-12 col-lg-4 mb-4 mb-lg-0">
                    <div class="shadow-lg rounded">
                        <div class="media bg-success justify-content-center text-align-center p-3 rounded-top" style="
                                background-image: url(<?= assets_url('/img/background_2.jpg', __FILE__) ?>);">
                            <img src="<?= assets_url('img/calculator.svg', __FILE__) ?>" class="mr-3 align-self-center img-fluid" alt="">
                            <h4 class="text-white text-uppercase align-self-center text-center mb-0">Калькулятор СДЭК</h4>
                        </div>
                        <form action="1" class="p-3" id="calculatorForIndex">
                            <div class="form-group">
                                <label for="calculatorForIndex-senderCity">Город отправителя:</label>
                                <input class="form-control border-success" placeholder="Москва" name="senderCity" id="calculatorForIndex-senderCity" required>
                                <input name="senderCityId" hidden>
                            </div>
                            <div class="form-group">
                                <label for="calculatorForIndex-receiverCity">Город получателя:</label>
                                <input class="form-control border-success" placeholder="Санкт-Петербург" name="receiverCity" id="calculatorForIndex-receiverCity" required>
                                <input name="receiverCityId" hidden>
                            </div>
                            <div class="form-group">
                                <label for="calculatorForIndex-weight">Вес:</label>
                                <div class="input-group">
                                    <input class="form-control border-success" placeholder="3" name="_weight" id="calculatorForIndex-weight" type="number" min="0" step="any">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-success border-success text-white">кг</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="calculatorForIndex-length">Габариты Д&times;Ш&times;В (см):</label>
                                <div class="input-group">
                                    <input class="form-control border-success" placeholder="10" name="_length" id="calculatorForIndex-length" type="number" min="0" step="any">
                                    <div class="input-group-prepend input-group-append">
                                        <span class="input-group-text bg-success border-success text-white">&times;</span>
                                    </div>
                                    <input class="form-control border-success" placeholder="10" name="_width" type="number" min="0" step="any">
                                    <div class="input-group-prepend input-group-append">
                                        <span class="input-group-text bg-success border-success text-white">&times;</span>
                                    </div>
                                    <input class="form-control border-success" placeholder="10" name="_height" type="number" min="0" step="any">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success w-100" id="calculatorForIndex-addPlace">Добавить место</button>
                            </div>
                            <div class="form-group">
                                <p>Количество мест:</p>
                                <ul class="list-group list-group-flush" id="calculatorForIndex-places"></ul>
                            </div>
                            <div class="form-group">
                                <label for="calculatorForIndex-cod_cost">Объявленная ценность:</label>
                                <div class="input-group">
                                    <input class="form-control border-success" placeholder="0" name="cod_cost" id="calculatorForIndex-cod_cost" type="number" min="0" step="any">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-success border-success text-white">&#8381;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" name="cod_payment_method" id="calculatorForIndex-cod_payment_method">
                                <label class="form-check-label" for="calculatorForIndex-cod_payment_method">Наложенный платеж</label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success w-100">Рассчитать</button>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="shadow-lg rounded">
                        <div class="table-responsive-lg overflow-auto">

                            <div class="table table-striped" id="table">

                                <div class="thead">
                                <div class="row">
                                    <div class="col-md-4 align-middle table__th table__th_first"><small>Москва &rarr; Санкт-Петербург, 3 кг, 0.003 м<sup>3</sup>, объемный вес: 0.6 кг</small></div>
                                    <!--  <th scope="col" class="align-middle bg-success text-white text-center table__th" data-toggle="tooltip" data-placement="bottom" title="СДЭК предлагает комплекс услуг для компаний, осуществляющих дистанционную торговлю, включающий в себя доставку со склада организации до конечного потребителя и прием денежных средств за товар от имени и по поручению компании, занимающейся дистанционной торговлей.">С договором интернет-магазина</th> -->
                                    <div class="col-md-4 align-middle bg-success bg-success_transparent text-center table__th" data-toggle="tooltip" data-placement="bottom" title="После заключения договора у Вас появиться «Личный Кабинет» на сайте СДЭК. В нем вы сможете создавать, отслеживать, проверять, запрашивать и формировать накладные, счета, акты, реестры и многое другое в режиме online.">С обычным договором</div>
                                    <div class="col-md-4 align-middle text-center table__th table__th_last">Обычная отправка</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 align-middle text-uppercase font-weight-normal">Услуга</div>
                                    <div class="col-md-3 align-middle text-uppercase font-weight-normal">Режим</div>
                                    <div class="col-md-6 align-middle text-center text-uppercase font-weight-normal">Стоимость</div>

                                </div>
                                </div>

                                <div class= "tbody">

                                    <!-- item -->
                                <div class="row">
                                    <div class="col-md-3 bg-white" data-toggle="tooltip" data-placement="right" title="Одна из самых популярных услуг СДЭК для Интернет-Магазинов (при наличии договора с нашей компанией).">
                                        <div>Посылка</div>
                                        <div class="text-success">1-2 дня</div>
                                    </div>

                                    <div class="col-md-9">

                                        <div class="row">
                                            <div class="col-md-4 align-middle"><nobr>дверь &rarr; дверь</nobr></div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">450 &#8381;</div>
                                            <div class="col-md-4 text-center align-middle"><img src="<?= assets_url('img/tables/no.svg', __FILE__) ?>" alt="" width="20"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 align-middle">
                                                <nobr>склад &rarr; дверь</nobr>
                                            </div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">310 &#8381;</div>
                                            <div class="col-md-4 text-center align-middle"><img src="<?= assets_url('img/tables/no.svg', __FILE__) ?>" alt="" width="20"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 align-middle">
                                                <nobr>дверь &rarr; склад</nobr>
                                            </div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">310 &#8381;</div>
                                            <div class="col-md-4 text-center align-middle"><img src="<?= assets_url('img/tables/no.svg', __FILE__) ?>" alt="" width="20"></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 align-middle">
                                                <nobr>склад &rarr; склад</nobr>
                                            </div>
                                            <div class="col-md-4 text-center text-success font-weight-bold align-middle">170 &#8381;</div>
                                            <div class="col-md-4 text-center align-middle"><img src="<?= assets_url('img/tables/no.svg', __FILE__) ?>" alt="" width="20"></div>
                                        </div>

                                    </div>
                                </div>

                                    <!-- item -->






                                <div class="row">
                                    <div class="col-md-3 bg-white" data-toggle="tooltip" data-placement="right" title="Доставка легких грузов по России.">
                                        <div>Экспресс-лайт</div>
                                        <div class="text-success">1-2 дня</div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4 align-middle"><nobr>дверь &rarr; дверь</nobr></div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">703 &#8381;</div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">703 &#8381;</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 align-middle"><nobr>склад &rarr; дверь</nobr></div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">617.5 &#8381;</div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">617.5 &#8381;</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 align-middle"><nobr>дверь &rarr; склад</nobr></div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">617.5 &#8381;</div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">617.5 &#8381;</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 align-middle">
                                                <nobr>склад &rarr; склад</nobr>
                                            </div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">541.5 &#8381;</div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">541.5 &#8381;</div>
                                        </div>

                                    </div>
                                </div>





                                <div class="row">
                                    <div class="col-md-3 bg-white" data-toggle="tooltip" data-placement="right" title="Экономичная доставка больших грузов по России.">
                                        <div>Магистральный экспресс</div>
                                        <div class="text-success">2 дня</div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4 align-middle"><nobr>склад &rarr; склад</nobr></div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">598.5 &#8381;</div>
                                            <div class="col-md-4 text-center font-weight-bold align-middle">598.5 &#8381;</div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-3 bg-white" data-toggle="tooltip" data-placement="right" title="Недорогая наземная доставка для Интернет-Магазинов (при наличии договора с нашей компанией).">
                                        <div>Экономичная посылка</div>
                                        <div class="text-success">5 дней</div>
                                    </div>
                                    <div class="col-md-9">

                                        <div class="row">
                                            <div class="col-md-4 align-middle"><nobr>склад &rarr; склад</nobr></div>
                                            <div class="col-md-4 text-center align-middle"><img src="<?= assets_url('img/tables/no.svg', __FILE__) ?>" alt="" width="20"></div>
                                            <div class="col-md-4 text-center align-middle"><img src="<?= assets_url('img/tables/no.svg', __FILE__) ?>" alt="" width="20"></div>
                                        </div>

                                    </div>
                                </div>


                                </div><!-- end tbody -->
                                
<div class="row">
                                    
                                    <div class="col-6"><button class="btn btn-success w-100 calculatorForIndex-contact-form">Заключить договор</button></div>
                                    <div class="col-6"><button class="btn btn-success w-100 calculatorForIndex-contact-form">Заключить договор</button></div>
                                </div><!-- end btn -->
                                
                                
                         </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="modal fade" id="modalMessage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-body text-center" id="modalMessage-body">
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalform" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-body text-center" id="modalMessage-body">
                <?= do_shortcode(get_option('transportcalccdek')['modal_content']) ?>
            </div>
        </div>
    </div>
</div>
