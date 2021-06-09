

        class AppModel {


            /**
             * Get list cites by term
             */
            static getListByTerm(inputSelector, response) {
                return $.ajax({
                    url: 'https://api.cdek.ru/city/getListByTerm/jsonp.php?callback=?',
                    dataType: 'jsonp',
                    data: {
                        q: $(inputSelector).val(),
                        name_startsWith: $(inputSelector).val()
                    },
                    success: (data) => response($.map(data.geonames, (item) => ({
                        label: item.name,
                        value: item.name,
                        id: item.id
                    })))
                });
            }

            /**
             * Get table price by form data
             * @param formData
             * @returns {Promise<Response>}
             */
            static getTablePrice(formData) {
                var response = null;
                formData.append("action", "cdek_get_price");

                $.ajax({
                    url: elementorCommonConfig.ajax.url,
                    type: "POST",
                    processData: false,
                    contentType: false,
                    async: false,
                    error: function( jqXHR, textStatus, errorThrown ){
                        console.log('ОШИБКА: ' + textStatus );
                    },
                    data: formData

                }).done(function(data) {
                    response = data;
                });
                return response;
            }
}

