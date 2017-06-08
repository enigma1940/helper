var checkUser = false;
function checkConf(a, b){
  a.keyup(function(){
    if(a.val().length>7 && a.val()==b.val()){ a.css('background','none'); }
    else{a.css('background','rgba(255, 122, 0, 0.64)'); }
  });
  return (a.val().length>7 && a.val()==b.val());
}
function checkField(a, b){
  a.keyup(function(){
    if(a.val().length>b){
      a.css('background','none');
    }else{a.css('background','rgba(255, 122, 0, 0.64)');}
  });
  return a.val().length>b;
}
checkField($('.nom'), 1);
checkField($('.prenom'), 2);
$('.username').keyup(function(){
  $.post(
    'php/suscribe.php',
    {
      pseudo: $(this).val(),
      opt : 'pseudo'
    },
    function(data){
      if(data=='ok'){$('.username').css('color','#000'); $('.pseudoBad').css('display','none');$('.pseudoOk').css('display','block'); checkUser=true;}
      else{$('.username').css('color','rgb(240, 108, 0)');  $('.pseudoBad').css('display','block');$('.pseudoOk').css('display','none'); checkUser=false;}
    }
  );
});
var shopOK;
$('.bname').keyup(function(){
  $.post(
    'php/suscribe.php',
    {
      bname: $(this).val(),
      opt: 'bname'
    },
    function(data){
      if(data=='success'){$('.bname').css('color','#000'); shopOK=true;}
      else{$('.bname').css('color','rgb(240, 108, 0)'); shopOK=false;}
    }
  );
});

checkField($('.password'), 7);
checkField($('.contact'), 7);
checkConf($('.confpass'), $('.password'));
checkField($('.mail'), 5);

$('.inscform').submit(function(e){
  e.preventDefault();
  if(checkField($('.nom'), 1) && checkField($('.prenom'), 2) && checkUser && checkField($('.password'), 7) &&
    checkField($('.contact'), 7) && checkConf($('.confpass'), $('.password'))){
      $.post(
        'php/suscribe.php',
        {
          opt: 'ok',
          nom: $('.nom').val(),
          prenom: $('.prenom').val(),
          uname: $('.username').val(),
          password: $('.password').val(),
          mail: $('.mail').val(),
          contact: $('.contact').val()
        },
        function(data){}
      );
      //$('.inscription').toggle('drop');
      //$('.inscResult').css('display', 'block');

    }
  else{$('.Berr').toggle('drop');}
});

checkField($('.userPass'), 7);
$('.connForm').submit(function(e){
  e.preventDefault();
  if($('.userName').val().length>2 && $('.userPass').val().length>7){
    $.post(
      'php/suscribe.php',
      {opt: 'connect',
      uname: $('.userName').val(),
      password: $('.userPass').val()},
      function(data){
        if(data=='success'){
          document.location.href='connexion';
        }else{
          $('.loginErr').css('display', 'block');
        }
      }
    );
  }else{
    $('.loginErr').css('display', 'block');
  }
});
