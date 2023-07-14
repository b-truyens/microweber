@php
    $md5name = md5($input->getAttribute('name'));
@endphp

<input style="display:none;" {!! $renderAttributes !!} id="{{$md5name}}" />

<input type="button" style="
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background:#ffffff;
  font-size:0px;
  cursor: pointer;
  border: 1px solid #cacaca;"
  id="open-color-picker-{{$md5name}}"
 />

<script>

    $(document).ready(function () {
        let element = document.getElementById('open-color-picker-{{$md5name}}');
        element.addEventListener('click', function () {

            let colorPicker = mw.app.colorPicker;
            colorPicker.positionToElement(element);
            colorPicker.selectColor('#{{$md5name}}', function(color) {
                element.style.backgroundColor = color;
            });

        });
    });
</script>
