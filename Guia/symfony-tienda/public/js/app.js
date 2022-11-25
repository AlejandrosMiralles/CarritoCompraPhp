//Immediately-Invoked Function Expression (IIFE)
(function(){
    const infoProduct = $("#infoProduct");
    $( "a.open-info-product" ).click(function(event) {
      event.preventDefault();
      const id = $( this ).attr('data-id');
      const href = `/api/show/${id}`;
      $.get( href, function(data) {
        $( infoProduct ).find( "#productName" ).text(data.name);
        $( infoProduct ).find( "#productPrice" ).text(data.price);
        $( infoProduct ).find( "#productImage" ).attr("src", "/img/" + data.photo);
        infoProduct.modal('show');
      })
    });
    $(".closeInfoProduct").click(function (e) {
      infoProduct.modal('hide');
    });

    const cartProduct = $("#cart-modal");
    $("a.open-cart-product").click(function(event){
      event.preventDefault();
      const id = $(this).attr('data-id');
      const href = `/cart/add/${id}`;
      $.get(href, function(data) {
        $( cartProduct ).find( "#productName" ).text(data.name);
        $( cartProduct ).find( "#productImage" ).attr("src", "/img/" + data.photo);
        cartProduct.modal('show');
      })
    });

    $(".closeCart").click(function (e) {
      cartProduct.modal('hide');
    });
})();
