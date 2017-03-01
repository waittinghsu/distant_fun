/**
 * methods page
 */
( function( window ) {
//'use strict';
var MD = window.MD;
// var $ = window.jQuery;
var heroContainer;
var heroMasonry;
var loadMoreButton;
// --------------------------  -------------------------- //
MD.index = function() {
  // ----- hero ----- //
  ( function() {
    var hero = document.querySelector('#hero');
    heroContainer = hero.querySelector('.hero-masonry');
    heroMasonry = new Masonry( heroContainer, {
      itemSelector: '.hero-item',
      columnWidth: '.grid-sizer'
    });
    getExamples();
  })();
  //loadMoreButton = document.querySelector('#load-more-examples');

};
function getExamples() {
  var items = [];
  var fragment = document.createDocumentFragment();
  var data = examplesData;

  for ( var i=0, len = data.length; i < len; i++ ) {
    var item = makeExampleItem( data[i] );
    items.push( item );
    fragment.appendChild( item );
    
  }

  imagesLoaded( fragment )
    .on( 'progress', function( imgLoad, image ) {
      var item = image.img.parentNode.parentNode;
      
      heroContainer.appendChild( item );
      heroMasonry.appended( item );
    });
}
//
//var examplesData = [
//  {
//    title: "輕薄自然透紅 &#8203; 不出油不脫粧！戀夏50日，立即終結單身！分享人氣網模心得抽Za裸粧心機輕潤粉底液！",
//    name: "namehttp://resize.thatsh.it/",
//    url: "url#",
//    image: "https://graph.facebook.com/1424110617/picture?type=large"
//  },
//  {
//    title: "Halcyon theme",
//    name: "http://resize.thatsh.it/",
//    url: "#",
//    image: "https://graph.facebook.com/1424110617/picture?type=large"
//  }
//];

function makeExampleItem( dataObj ) {
  var item = document.createElement('div');
  item.className = 'hero-item has-example';
  //var link = document.createElement('div');
  
  // link.href = '#';
  var img = document.createElement('img');
  img.src = dataObj.image;  

  //名子
  var data_example_name = document.createElement('div');
  data_example_name.className = 'example-name';
  data_example_name.textContent = dataObj.name;  
  //內容
  var data_example_description = document.createElement('div'); 
  data_example_description.className = 'example-description';  
  var img_little = document.createElement('img');
  img_little.src = dataObj.image;  
  var littleimg_text = document.createTextNode(dataObj.description);
  
    
  data_example_description.appendChild(img_little);
  data_example_description.appendChild(littleimg_text);

  
  item.appendChild( img );
  item.appendChild( data_example_name );  
  item.appendChild( data_example_description );
 // item.appendChild( link );
  return item;

}

})( window );
