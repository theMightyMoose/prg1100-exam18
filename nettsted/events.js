function updateHotels(selected){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            document.getElementById("selected-hotel").innerHTML=request.responseText; /* Responsteksten legges i meldingsfeltet */
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?location="+selected); /* Angir metode og URL */
    request.send(); /* Sender en request */
}

function updateCheckIn(date){
    var d = new Date(date);
    var weekday = new Array(7);
    weekday[0] = "Søndag";
    weekday[1] = "Mandag";
    weekday[2] = "Tirsdag";
    weekday[3] = "Onsdag";
    weekday[4] = "Torsdag";
    weekday[5] = "Fredag";
    weekday[6] = "Lørdag";
    var day = weekday[d.getDay()];
    document.getElementById("check-out").min=d.getFullYear() + '-' +('0' + (d.getMonth()+1)).slice(-2)+ '-' +('0' + (d.getDate()+1)).slice(-2); //+1
    document.getElementById("check-in-day").innerHTML=day;
    updateCountDays();
}

function updateCheckOut(date){
    var d = new Date(date);
    var weekday = new Array(7);
    weekday[0] = "Søndag";
    weekday[1] = "Mandag";
    weekday[2] = "Tirsdag";
    weekday[3] = "Onsdag";
    weekday[4] = "Torsdag";
    weekday[5] = "Fredag";
    weekday[6] = "Lørdag";
    var day = weekday[d.getDay()];
    document.getElementById("check-in").max=d.getFullYear() + '-' +('0' + (d.getMonth()+1)).slice(-2)+ '-' +('0' + (d.getDate()+1)).slice(-2); //-1
    document.getElementById("check-out-day").innerHTML=day;
    updateCountDays();
}

function updateCountDays(){
    var checkIn = new Date(document.getElementById("check-in").value);
    var checkOut = new Date(document.getElementById("check-out").value);
    var timeDiff = Math.abs(checkOut.getTime() - checkIn.getTime());
    var countDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    if (isNaN(countDays)) document.getElementById("count-days").innerHTML="0";
    if (!isNaN(countDays)) document.getElementById("count-days").innerHTML=countDays;
    if (countDays==1) document.getElementById("count-days-text").innerHTML="Natt";
    if (countDays==0 || countDays > 1) document.getElementById("count-days-text").innerHTML="Netter";
}

function validateSearch(l,h,i,o,m){
    if(i == "" || h == "" || i == "" || o == ""){
        document.getElementById("ajax").innerHTML = "Alle feltene må fylles ut.";
        return false;
    } else {
        if(m==1){
            openModal(1);
        }
        console.log(l,h,i,o,m);
        return true;
    }
}

function confirmOrder(entry,user,location,hotel,roomType,checkIn,checkOut,price,selectedRoom,orderDate){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById("loader"+entry).innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader-64.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            var response = request.responseText;
            if(response.indexOf('|$|' != -1)) {
                update = response.split('|$|');
            }
            document.getElementById("hotel-results").innerHTML='<div class="results-title"><h2 class="search-title-top">Søkeresultat</h2></div><hr>'+update[1];
            document.getElementById("modal-confirm").innerHTML=update[0]; /* Responsteksten legges i meldingsfeltet */
            document.getElementById("modal-confirm").className += " open";
            showSlideStart();
            document.body.className = "";
        }
    };
    
    request.open("GET","search.ajax.php?new_booking&e="+entry+"&u="+user+"&l="+location+"&h="+hotel+"&r="+roomType+"&i="+checkIn+"&o="+checkOut+"&p="+price+"&rn="+selectedRoom+"&od="+orderDate); /* Angir metode og URL */
    request.send(); /* Sender en request */
    
}
function confirmLogin(username,password,location,hotel,checkIn,checkOut){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById("modal-entries").innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader-64.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            document.getElementById("modal-content").innerHTML=request.responseText; /* Responsteksten legges i meldingsfeltet */
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?login&username="+username+"&password="+password+"&selected_location="+location+"&selected_hotel="+hotel+"&check_in="+checkIn+"&check_out="+checkOut); /* Angir metode og URL */
    request.send(); /* Sender en request */
}

function sessionSearch(username,password,location,hotel,checkIn,checkOut){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById("modal-entries").innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader-64.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            document.getElementById("modal-entries").innerHTML=request.responseText; /* Responsteksten legges i meldingsfeltet */
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?register_session&username="+username+"&password="+password+"&selected_location="+location+"&selected_hotel="+hotel+"&check_in="+checkIn+"&check_out="+checkOut); /* Angir metode og URL */
    request.send(); /* Sender en request */
}

function confirmRegister(username,password,location,hotel,checkIn,checkOut){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById("modal-entries").innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader-64.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            document.getElementById("modal-content").innerHTML=request.responseText; /* Responsteksten legges i meldingsfeltet */
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?reg_ses&reg_ses_u="+username+"&reg_ses_p="+password+"&reg_ses_l="+location+"&reg_ses_h="+hotel+"&reg_ses_i="+checkIn+"&reg_ses_o="+checkOut); /* Angir metode og URL */
    request.send(); /* Sender en request */
}

function login(username,password){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    
    document.body.className = "loading";
    document.getElementById("modal-entries").innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader-64.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            var response = request.responseText;
            if(response.indexOf('|$|' != -1)) {
                update = response.split('|$|');
            }
            document.getElementById("modal-entries").innerHTML=update[0]; /* Responsteksten legges i meldingsfeltet */
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?minside_login&username="+username+"&password="+password); /* Angir metode og URL */
    request.send(); /* Sender en request */
}
function register(username,password){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    username = "&u="+username;
    password = "&p="+password;
    post = username+password;
    document.body.className = "loading";
    document.getElementById("modal-entries").innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader-64.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            document.getElementById("modal-content").innerHTML=request.responseText; /* Responsteksten legges i meldingsfeltet */
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?minside_register"+post); /* Angir metode og URL */
    request.send(); /* Sender en request */
}

function editOrder(orderNr,user,orderId,hotel,roomType,checkIn,checkOut,price,roomNr){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById('loader'+orderNr).innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            document.getElementById("bookings").innerHTML=request.responseText; /* Responsteksten legges i meldingsfeltet */
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?edit_order="+orderNr+"&user="+user+"&order=order"+orderNr+"&order_id="+orderId+"&edit_hotel="+hotel+"&edit_room_type="+roomType+"&check_in="+checkIn+"&check_out="+checkOut+"&price="+price+"&room_nr="+roomNr); /* Angir metode og URL */
    request.send(); /* Sender en request */
}
function confirmEditOrder(orderNr,user,hotel,orderId,newRoomType,newCheckIn,newCheckOut,price,roomNumber){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById('loader'+orderNr).innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            var response = request.responseText;
            if(response.indexOf('|$|' != -1)) {
                update = response.split('|$|');
            }
            document.getElementById("order"+orderNr).innerHTML=update[0]; /* Responsteksten legges i meldingsfeltet */
            document.getElementById("modal"+orderNr).innerHTML=update[1];
            document.getElementById("modalorder"+orderNr).className=document.getElementById("modalorder"+orderNr).className.replace(" open", "");
            
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?confirm_edit_order="+orderNr+"&user="+user+"&edit_hotel="+hotel+"&order_id="+orderId+"&edit_room_type="+newRoomType+"&check_in="+newCheckIn+"&check_out="+newCheckOut+"&price="+price+"&room_number="+roomNumber); /* Angir metode og URL */
    request.send(); /* Sender en request */
}
function updatePrice(orderNr,user,orderId,element,hotel,roomType,roomNumber,checkIn,checkOut){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById('loader'+orderNr).innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            var response = request.responseText;
            if(response.indexOf('|$|' != -1)) {
                update = response.split('|$|');
            }
            document.getElementById("check_inorder"+orderNr).innerHTML=update[0]; //check in
            document.getElementById("check_outorder"+orderNr).innerHTML=update[1]; //check out
            document.getElementById(element).innerHTML=update[2]; /* priceorder1 - prisen i tabellen */
            document.getElementById("confirm-edit").innerHTML=update[3]; //confirm-knappen
            document.getElementById("modalorder"+orderNr).innerHTML=update[4];
            document.getElementsByName(element).value=update[5];
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?update_price="+orderNr+user+orderId+hotel+roomType+roomNumber+checkIn+checkOut); /* Angir metode og URL */
    request.send(); /* Sender en request */
}
function cancelOrder(orderId,user){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById('loader').innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            var response = request.responseText;
            if(response.indexOf('|$|' != -1)) {
                update = response.split('|$|');
            }
            document.getElementById("minebestillinger").innerHTML=update[0]; /* Responsteksten legges i meldingsfeltet (priceorder1)*/
            document.getElementById("ajax").innerHTML=update[1];
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?cancel_order="+orderId+"&user="+user); /* Angir metode og URL */
    request.send(); /* Sender en request */
}
function unedit(on,u,h,oid,rt,i,o,p,rn){
    var request=new XMLHttpRequest(); /* Oppretter request-objekt */
    document.body.className = "loading";
    document.getElementById('loader'+on).innerHTML='<div class="loader-div"><img class="loader" src="../includes/files/loader.gif" alt=""></div>';
    request.onreadystatechange=function(){
        if(request.readyState==4 && request.status==200){ /* Responsen er fullført og vellykket */
            var response = request.responseText;
            if(response.indexOf('|$|' != -1)) {
                update = response.split('|$|');
            }
            document.getElementById("order"+on).innerHTML=update[0]; /* Responsteksten legges i meldingsfeltet (priceorder1)*/
            document.body.className = "";
        }
    };
    request.open("GET","search.ajax.php?unedit="+on+"&u="+u+"&oid="+oid+"&h="+h+"&rt="+rt+"&i="+i+"&o="+o+"&p="+p+"&rn="+rn); /* Angir metode og URL */
    request.send(); /* Sender en request */
}
/* MODAL  */
// Get the modal
function openModal(id){
    var modal = document.getElementById("modal"+id);
    
    // Get the button that opens the modal
    var btn = document.getElementById("modalBtn"+id);
    
    // Get the <span> element that closes the modal
    
    
    // When the user clicks the button, open the modal 
    //modal.style.display = "block";
        modal.className += " open";
        
    
    // When the user clicks on <span> (x), close the modal
    
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            //modal.style.display = "none";
            modal.className = modal.className.replace(" open", "");
        }
    }
}
function closeModal(id){
    var span = document.getElementsByClassName("close")[0];
    var modal = document.getElementById("modal"+id);
    modal.className = modal.className.replace(" open", "");
}

