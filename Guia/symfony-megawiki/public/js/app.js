//Immediately-Invoked Function Expression (IIFE)
(function(){
    //Event to update the number of Items on the car that is shown on the nav
    function updateTotalCartItems(){
      cartElement = $("#navCartLink");
      hrefTotalitems = "/cart/totalItems";
      totalElements= -1;
      $.get(hrefTotalitems, function(data){
        totalElements = data.totalCart;
        cartElementText = "Cart (" + totalElements + ")";      
        cartElement.text(cartElementText);
      });

      
    }


    //Events to see the product
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



    //Events to add a product to the cart 
    const cartProduct = $("#cart-modal");
    $("a.open-cart-product").click(function(event){
      event.preventDefault();
      idToShow = $(this).attr('data-id');
      const href = `/product/getJson/${idToShow}`;
      $.get(href, function(data) {
        $( cartProduct ).find( "#productName" ).text(data.name);
        $( cartProduct ).find( "#productImage" ).attr("src", "/img/" + data.photo);
        $( cartProduct ).find( "#productName" ).attr("data-id", data.id);
        cartProduct.modal('show');
      })
    });



    
    //Event to update the product's quantity
    $("#updateCart").click(function(event){
      quantity = $("#quantity").val();
      hrefUpdateCart = `/cart/update/${idToShow}/${quantity}`;
      
      $.get(hrefUpdateCart);

      updateTotalCartItems();

    });

    $(".closeCart").click(function (e) {
      cartProduct.modal('hide');
    });








    //Event to update the number of items on the cart
    function updateTotalCartPrice(){
      priceElement = $("#totalCart");
      priceElementText = "";

      items = $(".itemOnTheCart");
      totalPrice = 0;
      
      for(i=0; i < items.length; ++i){
        item = items[i];

        itemPrice = $(item).find("[item-price]").attr("item-price");
        itemQuantity = $( item ).find("[item-quantity]").attr("item-quantity");
        
        totalPrice += itemPrice * itemQuantity;
      }

      priceElementText = `Total ${ totalPrice}€`;
      priceElement.text(priceElementText);

    }

    //Event to remove items from a cart
    $("a#removeProduct").click(function (e){
      e.preventDefault();
      id = $(this).attr("item-id");
      parameters = "id=" + id;
      href = `/cart/delete/${id}`;

      $.post(href, parameters);

      $(`#item-${id}`).remove(); 


      updateTotalCartPrice();

      updateTotalCartItems();
    });
})();
