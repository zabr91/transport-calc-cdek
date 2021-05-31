class AppView {

    static table(formDataArr, weight, volume, volumeWeight, data){
        let html = ` 
						<thead>
							<tr>
							<th scope="col" colspan="2" class="align-middle table__th table__th_first">
								<small>
									${formDataArr['senderCity']} &rarr; ${formDataArr['receiverCity']}, ${weight} кг,
									${volume} м<sup>3</sup>, объемный вес: ${volumeWeight.toFixed(3)} кг
								</small>
							</th>
						<!--	<th scope="col" class="align-middle bg-success text-white text-center table__th" data-toggle="tooltip" data-placement="bottom" title="СДЭК предлагает комплекс услуг для компаний, осуществляющих дистанционную торговлю, включающий в себя доставку со склада организации до конечного потребителя и прием денежных средств за товар от имени и по поручению компании, занимающейся дистанционной торговлей.">С договором интернет-магазина</th>-->
							<th scope="col" class="align-middle bg-success bg-success_transparent text-center table__th" data-toggle="tooltip" data-placement="bottom" title="После заключения договора у Вас появиться «Личный Кабинет» на сайте СДЭК. В нем вы сможете создавать, отслеживать, проверять, запрашивать и формировать накладные, счета, акты, реестры и многое другое в режиме online.">С обычным договором</th>
							<th scope="col" class="align-middle text-center table__th table__th_last">Без договора</th>
							</tr>
							<tr>
							<th scope="col" class="align-middle text-uppercase font-weight-normal">Услуга</th>
							<th scope="col" class="align-middle text-uppercase font-weight-normal">Режим</th>
							<th scope="col" colspan="1" class="align-middle text-center text-uppercase font-weight-normal">Стоимость</th>
							<th scope="col" colspan="2"></th>
							</tr>
						</thead>
						<tbody>
					`;

        for (let service of data.services) {
            let count = 0
            let serviceHTML = ''

            if (service['doorToDoor']) {
                let modeHTML = '<td class="align-middle"><nobr>дверь &rarr; дверь</nobr></td>'

                for (let price of service['doorToDoor']['price']) {
                    let priceHTML = '<img src="img/tables/no.svg" alt="" width="20">'

                    if (price) {
                       /* if (price === data.minPrice) {
                            priceHTML = `<span class="text-success">${price} &#8381;<span class="text-success">`
                        } else {*/
                            priceHTML = `${price} &#8381;`
                       //s }
                    }

                    modeHTML += `<td class="text-center font-weight-bold align-middle">${priceHTML}</td>`
                }

                serviceHTML += serviceHTML ? `<tr>${modeHTML}</tr>` : `${modeHTML}</tr>`
                count++
            }

            if (service['warehouseToDoor']) {
                let modeHTML = '<td class="align-middle"><nobr>склад &rarr; дверь</nobr></td>'

                for (let price of service['warehouseToDoor']['price']) {
                    let priceHTML = '<img src="img/tables/no.svg" alt="" width="20">'

                    if (price) {
                        /*if (price === data.minPrice) {
                            priceHTML = `<span class="text-success">${price} &#8381;<span class="text-success">`
                        } else {*/
                            priceHTML = `${price} &#8381;`
                       // }
                    }

                    modeHTML += `<td class="text-center font-weight-bold align-middle">${priceHTML}</td>`
                }

                serviceHTML += serviceHTML ? `<tr>${modeHTML}</tr>` : `${modeHTML}</tr>`
                count++
            }

            if (service['doorToWarehouse']) {
                let modeHTML = '<td class="align-middle"><nobr>дверь &rarr; склад</nobr></td>'

                for (let price of service['doorToWarehouse']['price']) {
                    let priceHTML = '<img src="img/tables/no.svg" alt="" width="20">'

                    if (price) {
                      /*  if (price === data.minPrice) {
                            priceHTML = `<span class="text-success">${price} &#8381;<span class="text-success">`
                        } else {*/
                            priceHTML = `${price} &#8381;`
                     //   }
                    }

                    modeHTML += `<td class="text-center font-weight-bold align-middle">${priceHTML}</td>`
                }

                serviceHTML += serviceHTML ? `<tr>${modeHTML}</tr>` : `${modeHTML}</tr>`
                count++
            }

            if (service['warehouseToWarehouse']) {
                let modeHTML = '<td class="align-middle"><nobr>склад &rarr; склад</nobr></td>'

                for (let price of service['warehouseToWarehouse']['price']) {
                    let priceHTML = '<img src="img/tables/no.svg" alt="" width="20">'

                    if (price) {
                      /*  if (price === data.minPrice) {
                            priceHTML = `<span class="text-success">${price} &#8381;<span class="text-success">`
                        } else { */
                            priceHTML = `${price} &#8381;`
                        //}
                    }

                    modeHTML += `<td class="text-center font-weight-bold align-middle">${priceHTML}</td>`
                }

                serviceHTML += serviceHTML ? `<tr>${modeHTML}</tr>` : `${modeHTML}</tr>`
                count++
            }

            if (serviceHTML) {
                html += `
							  	<tr>
							  	  <th scope="row" rowspan="${count}" class="bg-white" data-toggle="tooltip" data-placement="right" title="${service['tooltipText']}">
							  	  	<div>${service.name}</div>
							  	  	<div class="text-success">${service.periodMin}-${service.periodMax} дня</div>
							  		</th>
							  	${serviceHTML}
								`
            }
        }


        const table = document.getElementById('table')

        table.innerHTML = `${html}</tbody>`
        let button = calculatorForIndex.querySelector('[type="submit"]')
        button.outerHTML = '<button type="submit" class="btn btn-success w-100">Рассчитать</button>'
        $('[data-toggle="tooltip"]').tooltip()
      //  preloader.classList.remove('preloader_active')
        table.scrollIntoView()
    }

}

})
})