

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
            static async getTablePrice(formData) {
                const response = await fetch('/wp-content/plugins/transport-calc-cdek/app/Controllers/AjaxController.php', {
                    method: 'POST',
                    body: formData,
                });

                return response;
            }
        }

