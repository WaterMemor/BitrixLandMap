$(window).on("load", 
function(){
    var all = [];
    var color = [];
    var uchN = [];
    var coupleLine = '';
    var pictureHeight = $('.pictureHeight').val(); //высота изображения (от него зависит масштаб отрисованных участков)
    var pictureWidth = $('.pictureWidth').val(); 
    
    $('.coord').each(function(){ //получаем координаты
    var eachCouple = $(this).val().split(",");
    color.push($(this).attr('status'));
    uchN.push($(this).attr('uchN'));
    all.push(eachCouple);
    })


    var heightCont = $('.cont').height(); //высота контейнера
    var widthCont = $('.cont').width();
    $('#svg').width(widthCont); //присваиваем нашему svg контейнеру ту же высоту тк пока он пуст
    $('#svg').height(heightCont);
    var countX = 0; //переменные для хранения двух угловых координат (для размещения по центру картинки дома, названия или номера участка)
    var countY = 0;
    var imgHouse = ""; //переменная для хранения картинки дома на участке

    $(all).each(function(index){ // получаем все участки
        coupleLine = 'points="';
        for(var x = 0; x < $(this).length; x++){
            var couple = $(this)[x].split("/"); //разделяем пары участков 

            imgHouse = '.img'+uchN[index]; 
            coupleLine += (couple[0]) + ',' + (pictureHeight - couple[1]+ " ");
            if(x==0 || x==2){
                countX += parseInt(couple[0]); 
                countY += parseInt(pictureHeight - couple[1]);
            }
        }
        document.getElementById('svg').innerHTML += "<polygon id=\"" + uchN[index] + "\" fill=\"" + color[index] + "\" class=\"fil0\" " + coupleLine +"\"/>"; //рисуем участок в svg
        houseHeight = $(imgHouse).height();
        $(imgHouse).css({top: heightCont*(countY/2-houseHeight+5)/pictureHeight, left: widthCont*(countX/2-20)/pictureWidth}); //смещаем наш домик согласно перспективе фотграфии
            
        

        numHouse = '.num'+uchN[index];
        numHeight = $(numHouse).height()/2;
        //в зависимости от размера экрана уменьшаем шрифт, изменяем смещение и тд
        if(widthCont <= 690 && widthCont > 425){
            $(numHouse).css({top: heightCont*(countY/2-20)/pictureHeight, left: widthCont*(countX/2+8)/pictureWidth});
            var houseSize =  $(imgHouse).width()*0.7;
            $(imgHouse).css({width: houseSize});

            $(".num").css("font-size","5px");

            $(".name").css("font-size","10px");
        }else if(widthCont <= 425){
            $(numHouse).css({top: heightCont*(countY/2-50)/pictureHeight, left: widthCont*(countX/2+8)/pictureWidth});
            var houseSize =  $(imgHouse).width()*0.3;
            $(imgHouse).css({width: houseSize});
 
            $(".num").css("font-size","3px");

            $(".name").css("font-size","5px");
        }else{
            $(numHouse).css({top: heightCont*(countY/2-$('#number').val())/pictureHeight, left: widthCont*(countX/2-$('#number').val())/pictureWidth});
        }

        countX = countY = imgHouse= 0;
    });
    

    //функции
    function hoverUch(e){
        var changeColor = '#'+e.attr('uchN');
        $(changeColor).css("opacity",1);
    }
    function leaveUch(e){
        var changeColor = '#'+e.attr('uchN');
        $(changeColor).css("opacity", 0.7);
    }
    function clickUch(e){
        var polygonId = '.'+e.attr('uchN');
        if($(polygonId).css("display")=="none"){
            $(polygonId).show();
            $('.bx-core').css("overflow", "hidden");
        }
    }

    //клик и наведение на фото, на номер
    //решает проблему изменения цвета участка при наведении на картинку дома
    $('.img_uch, .num').hover(function(){
        hoverUch($(this))
    }, function(){
        leaveUch($(this))
    });
    $('.img_uch, .num').click(function(){
        clickUch($(this));
    });

})