{!! HTML::script('vendor/simplemde/dist/simplemde.min.js') !!}
{!! HTML::style('vendor/simplemde/dist/simplemde.min.css') !!}
{!! HTML::script('plugins/autocomplete/dist/jquery.autocomplete.js') !!}


<script>
    $(function() {
        try {
            $(".geocomplete").geocomplete({
                    details: "form.gf",
                    types: ["geocode", "establishment"]
                }).bind("geocode:result", function(event, result) {
                    console.log(result);
            }, 1000);

        } catch (e) {
            console.log(e);
        }
        $('#autocomplete').autocomplete({
            serviceUrl: 'http://restapi.amap.com/v3/assistant/inputtips?key=02d2735755ffafa30dd2e2ea125b5ed7',
            paramName: 'keywords',
            transformResult: function(response) {
                var data = JSON.parse(response);
                return {
                    suggestions: $.map(data.tips, function(dataItem) {
                        console.log(dataItem.name);
                        return { value: dataItem.name, data: dataItem.id.toString() };
                    })
                };
            },
            onSelect: function (suggestion) {
                alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
            }
        });

        $('.editable').each(function() {
            var simplemde = new SimpleMDE({
                element: this,
                spellChecker: false,
                status: false
            });
            simplemde.render();
        })

        $("#DatePicker").remove();
        var $div = $("<div>", {id: "DatePicker"});
        $("body").append($div);
        $div.DateTimePicker({
            dateTimeFormat: window.newYlg.DateTimeFormat
        });

    });
</script>
<style>
    .editor-toolbar {
        border-radius: 0 !important;
    }
    .CodeMirror, .CodeMirror-scroll {
        min-height: 100px !important;
    }

    .create_organiser, .address-manual {
        padding: 10px;
        border: 1px solid #ddd;
        margin-top: 10px;
        margin-bottom: 10px;
        background-color: #FAFAFA;
    }

    .in-form-link {
        display: block; padding: 5px;margin-bottom: 5px;padding-left: 0;
    }
</style>
