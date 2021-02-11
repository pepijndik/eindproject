
(function ($) {

    "use strict";

    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit',function(){
        var check = true;

        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                check=false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    

 
    

})(jQuery);  

 function getBookedDates(){
     var today = new Date();
     var dd = today.getDate();

    var mm = today.getMonth()+1; 
    var yyyy = today.getFullYear();
    if(dd<10) 
    {
    dd='0'+dd;
    } 

    if(mm<10) 
    {
    mm='0'+mm;
    } 
         $.ajax({
        url: base_url + 'admin/reserveringen/booked',
        type: 'post',
        data: {
            datum: dd+'/'+mm+'/'+yyyy
        },
        dataType: 'json',
        success: function(response) {
            // return bookedDates;
        }
    });
    };


    function GetPrices(val) {

        $.ajax({
          url: base_url + '/admin/form',
          type: 'post',
          dataType: 'json',
          success: function(response){
              console.log(response);
              for( var i = 0, len = response.length; i < len; i++ ) {
                if( response[i]['what'] === val ) {
                   
                }
            }
          }
        }); //Fetch Prices 

      }

      function checkbox(box, id, form) {
        //console.log(box);
        if (box.checked) {
          if (document.getElementById(id + '_hidden') != null) {
            removeElement(id + '_hidden');
          }
        } else {
          createElementHidden(id, document.getElementById(form))
        }
      }
    
      function createElementHidden(id, form) {
        var input = document.createElement('input');
        input.id = id + '_hidden';
        input.name = 'value[]'
        input.type = 'hidden';
        input.value = off;
        form.appendChild(input);
      }

      this.default = function () {
        var seatInfo = document.getElementById('selectedseats');
        ej.maps.Maps.Inject(ej.maps.Selection);
        var maps = new ej.maps.Maps({
    
            projectionType: 'Equirectangular',
            itemSelection: function (args) {
                if (args.shapeData.fill === 'Orange') {
                    args.fill = 'Orange !important';
                    document.getElementById(args.target).setAttribute('class', 'ShapeselectionMapStyle');
                    return;
                }
                args.fill = 'green';
                var seat = args.shapeData.seatno;
                var connector = ' ';
                if (seatInfo.innerHTML === '') {
                    seatInfo.innerHTML = '<span id="seat-info">Seats Selected -</span>';
                }
                else {
                    connector = ', ';
                }
                var seatString = '<span class="seats">' + connector + seat + '</span>';
                var seatString1 = ' ' + seat + '</span><span class="seats">,';
                var lastString = '<span id="seat-info">Seats Selected -</span><span class="seats"> ' + seat + '</span>';
                if (seatInfo.innerHTML.indexOf(seatString) === -1 && seatInfo.innerHTML.indexOf(seatString1) === -1 &&
                    seatInfo.innerHTML.indexOf(lastString) === -1) {
                    seatInfo.innerHTML += '<span class="seats">' + connector + seat + '</span>';
                }
                else {
                    seatInfo.innerHTML = seatInfo.innerHTML.replace(seatString, '');
                    seatInfo.innerHTML = seatInfo.innerHTML.replace(seatString1, '');
                    if (seatInfo.innerHTML === lastString) {
                        seatInfo.innerHTML = '';
                    }
                }
            },
            height: '400',
            zoomSettings: {
                enable: false
            },
            layers: [
                {
                    geometryType: 'Normal',
                    shapeData: new ej.maps.MapAjax('./src/maps/map-data/seat.json'),
                    shapeSettings: {
                        colorValuePath: 'fill'
                    },
                    selectionSettings: {
                        enable: true,
                        opacity: 1,
                        enableMultiSelect: true
                    }
                }
            ]
        });
        maps.appendTo('#maps');
        // to clear the selected seats
        document.getElementById('clear-btn').onclick = function () {
            seatInfo.innerHTML = '';
            var selected = document.getElementsByClassName('ShapeselectionMapStyle');
            for (var i = 0, length_1 = selected.length; i < length_1; i++) {
                selected[0].setAttribute('class', '');
            }
        };
    };