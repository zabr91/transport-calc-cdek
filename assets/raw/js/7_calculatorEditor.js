
        AppController.autocomplete('#calculatorEditor [name=senderCity]', '#calculatorEditor [name=senderCityId]')
        AppController.autocomplete('#calculatorEditor [name=receiverCity]', '#calculatorEditor [name=receiverCityId]')

        const calculatorEditor = document.getElementById('calculatorEditor')
        const calculatorEditorCode = calculatorEditor.querySelector('#calculatorEditor-code')

        $('#calculator iframe')[0].height = $('#calculator iframe').contents().find('html').height() + 10
        calculatorEditorCode.innerHTML = $('#calculator iframe')[0].outerHTML
        $('#calculator iframe').on('load', function () {
            $(this)[0].height = $(this).contents().find('html').height() + 10
            calculatorEditorCode.innerHTML = $('#calculator iframe')[0].outerHTML
        });

        calculatorEditor.addEventListener('submit', (e) => {
            e.preventDefault()

            const formData = new FormData(calculatorEditor)
            let searchParams = new URLSearchParams();

            for (let [name, value] of formData) {
                if (name === 'receiverCity' || name === 'senderCity' || name === 'code') continue
                if (!value) continue

                searchParams.append(name, value)
            }

            searchParams = searchParams.toString()

            if (searchParams) {
                const calculator = document.querySelector('#calculator iframe')
                calculator.src = `https://cdekcalc.ru/calculator.php?${searchParams}`
            }
        })
    })
})
