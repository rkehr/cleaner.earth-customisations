
jQuery(document).ready(function( $ ) {

  //==================================
  // COUNTERS
  //==================================
  //TODO: refactor, comment

  window.clearPointsTypes = cl_ear_globals["points_types"];
  window.clearPointsValues = cl_ear_globals["points_values"];
  window.clearDynamicPointDisplays = new Object();
  window.clearCountupJsObjects = new Object();

  //initCoinCounters();
  $( '.point-converter' ).click(convertCoins);

  initDynamicPointDisplays();

  const users = [
    'currentUser',
    'global'
  ];
  const userCssPrefixes = {
    'currentUser' : 'current-user-',
    'global'      : 'global-'
  };

  const popUpText = {
    lingunan: {
      100: 'Danke dass du Jeffrey mit 100 AP unterstützt hast! :)',
      500: 'Wow! Fast zwei Kilo Plastik! Nice!',
      1000: 'Sehr Geil, da hat Jeffrey richtig was von! Danke Dir!'
    },
    error:{
      100: 'Sorry, dafür reichen Deine Aktionspunkte nicht mehr :c'
    }
  }

  function convertCoins( evt ){
    let classes = evt.target.className.split(" ");
    let project, amount;
    const conversionRate = .01;
    for (const i in classes){
      if (classes[i].startsWith("conversion")){
        let classSegments = classes[i].split("-");
        project = classSegments[1];
        amount = parseInt(classSegments[classSegments.length-1]);
      }
    }
    if(window.clearPointsValues['aktionspunkte'][users[0]] >= amount){
      for( let u of users){
        window.clearPointsValues['aktionspunkte'][u] -= amount;
        window.clearPointsValues['bonuspunkte'][u] += amount * conversionRate;
        window.clearPointsValues[ project + '-token'][u] += amount;
    }
    updatePointsDisplays();
    showPopUp(project, amount);
  }else{
    showPopUp('error', 100)
  }
  }


  function showPopUp( proj, amount){

    let currentText = 'Danke, dass Du dieses Projekt mit ' + amount + 'AP unterstützt! :)';

    if( popUpText[proj] != undefined ){
      if (popUpText[proj][amount] != undefined){
        currentText = popUpText[proj][amount];
      }
    }
    let popUp = jQuery.parseHTML('<div class="thank-you-popup pre">'+ currentText + '</div>')[0];
    popUp.onanimationend = (evt) => {
      evt.target.remove();
    }
    jQuery( '#coin-sidebar' ).before( popUp );
  }


  function initDynamicPointDisplays (){
    if(window.clearPointsTypes.length == 0){
      console.log("No points types found!");
      return;
    }
    //set countUpJs related options
    const countUpDecimals = 0;
    const countUpDuration = 5;
    const countUpOptions = {
      "separator": ' '
    }

    //iterate all registered points types and look for their respective points displays
    for( var c in window.clearPointsTypes){
      let pointsType = window.clearPointsTypes[c];

      //setup Object() structure to save countUp objects
      window.clearCountupJsObjects[pointsType] = new Object();

      //find current user point displays
      let userPointsDisplays = $( '.gamipress-is-current-user .gamipress-points.gamipress-user-points-' + pointsType + ' .gamipress-user-points-amount' ).add('.cleaner-inline-gamipress-user-points.gamipress-user-points-' + pointsType);
      //find global points displays
      let globalPointsDisplays = $( '.gamipress-points.gamipress-user-points-' + pointsType + ' .gamipress-user-points-amount' ).not('.gamipress-is-current-user .gamipress-points.gamipress-user-points-' + pointsType + ' .gamipress-user-points-amount').add('.cleaner-inline-gamipress-global-points.gamipress-user-points-' + pointsType);

      // add the user points displays if there are any of this pointstype
      if(userPointsDisplays.length != 0){

        window.clearCountupJsObjects[pointsType]['currentUser'] = new Object();
        window.clearDynamicPointDisplays['current-user-' + pointsType ] = userPointsDisplays;
        for( let i = 0; i < userPointsDisplays.length; i++){
          //add unique ID to each <span> that contains a current user points display
          let id = 'current-user-' + pointsType + '-' + i;
          let val = window.clearPointsValues[pointsType]['currentUser'];
          userPointsDisplays[i].id = 'current-user-' + pointsType + '-' + i;

          window.clearCountupJsObjects[pointsType]['currentUser'][i] = new CountUp(id , val,);
          window.clearCountupJsObjects[pointsType]['currentUser'][i].start();
        }
      }
      // add the global points displays if there are any of this pointstype
      if(globalPointsDisplays.length != 0){
        window.clearCountupJsObjects[pointsType]['global'] = new Object();
        window.clearDynamicPointDisplays['global-' + pointsType ] = globalPointsDisplays;
        for( let i = 0; i < globalPointsDisplays.length; i++ ){
          //add unique ID to each <span> that contains a global points display
          let id = 'global-' + pointsType + '-' + i;
          let val = window.clearPointsValues[pointsType]['global'];
          globalPointsDisplays[i].id = id ;

          window.clearCountupJsObjects[pointsType]['global'][i] = new CountUp(id, val);
          window.clearCountupJsObjects[pointsType]['global'][i].start();
        }
      }

    }

  }

//iterate all registered CountUpJs pointdisplays with the current ClearPointsValues
  function updatePointsDisplays(){
    for(let i in window.clearPointsTypes){
      let pointsType = window.clearPointsTypes[i];
      updatePointsDisplaysByType(pointsType);
    }
  }
  function updatePointsDisplaysByType( pointsType ){
    let globalCountUpObjs = window.clearCountupJsObjects[pointsType]['global'];
    if (globalCountUpObjs){
      for( i in globalCountUpObjs){
        globalCountUpObjs[i].update(window.clearPointsValues[pointsType]['global']);
      }
    }
    let currentUserCountUpObjs = window.clearCountupJsObjects[pointsType]['currentUser'];
    if (currentUserCountUpObjs){
      for( i in currentUserCountUpObjs){
        currentUserCountUpObjs[i].update(window.clearPointsValues[pointsType]['currentUser']);
      }
    }
  }

  function fetchPointValues(){
    jQuery.get(

      cl_ear_globals.ajax_url,
      {
        action: 'cl_ear_fetch_point_values',
        _ajax_nonce: cl_ear_globals.nonce
      },
      function( response ){
        if ( response.success === true ){
          delete response["success"];
          window.clearPointsValues = response;
        }else{
          console.log("Bad Response");
          console.log(response);
        }
      },
      'json'
    );
  }
});
