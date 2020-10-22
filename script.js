
function login() {
    // var element = document.getElementById("log");
    $('#log').addClass("login");
    $('#reg').removeClass("register");
    $('#textl').addClass("textWhite");
    $('#textl').removeClass("textBlack");
    $('#textr').addClass("textBlack");
}
// Reference : https://stackoverflow.com/questions/7002039/easiest-way-to-toggle-2-classes-in-jquery

function register() {
    // var element = document.getElementById("reg");
    $('#reg').addClass("register");
    $('#log').removeClass("login");
    $('#textl').removeClass("textWhite");
    $('#textl').addClass("textBlack");
    $('#textr').addClass("textWhite");
    $('#textr').removeClass("textBlack");
    // $('#target').removeClass("a").addClass("b");
}

function myDelete(d,t) {
    var id = d;
    var title = t;
    window.location.href = "deleteQue.php?deleteId="+id+"&title="+title;
}

function que_type_sort(){
    // Reference : https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onchange
    var search = document.getElementById("que_type_sort").value;
    // window.alert("Type : "+search);
    $.ajax({
        url:'questions.php',
        method:'post',
        data:{query:search},
        success:function(response){
            $("#ajax").html(response);
        },
    });
}
