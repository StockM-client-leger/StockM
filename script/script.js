const mouseLight = document.getElementById("mouse-light");
var timeout;

document.onmousemove = (event) => {
  mouseLight.style.opacity = 1;

  mouseLight.style.top = `${event.clientY - mouseLight.clientHeight / 2}px`;
  mouseLight.style.left = `${event.clientX - mouseLight.clientWidth / 2}px`;

  if (!timeout) window.clearTimeout(timeout);
  timeout = window.setTimeout(() => {
    mouseLight.style.opacity = 0;
  }, 2500);
};

document.addEventListener('DOMContentLoaded', () => {
  const sizeButtons = document.querySelectorAll('.sizes button');
  const addToCartButton = document.querySelector('.actions button');

  let selectedSize = null;

  sizeButtons.forEach(button => {
      button.addEventListener('click', () => {
          // Deselect other buttons
          sizeButtons.forEach(btn => btn.style.borderColor = '#ddd');
          // Select current button
          button.style.borderColor = '#FFD700';
          selectedSize = button.textContent;
      });
  });

  addToCartButton.addEventListener('click', () => {
      if (!selectedSize) {
          alert('Veuillez sélectionner une taille.');
          return;
      }

      // Save data to localStorage
      const product = {
          model: document.querySelector('.product-details h1').textContent,
          price: document.querySelector('.product-details .price').textContent,
          size: selectedSize
      };

      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      cart.push(product);
      localStorage.setItem('cart', JSON.stringify(cart));

      // Redirect to panier.html
      window.location.href = 'panier.php';
  });
});

document.addEventListener('DOMContentLoaded', () => {
  const cartContainer = document.querySelector('.cart-container');

  // Load cart data from localStorage
  const cart = JSON.parse(localStorage.getItem('cart')) || [];

  if (cart.length === 0) {
      cartContainer.innerHTML = '<p>Votre panier est vide.</p>';
      return;
  }

  cart.forEach(item => {
      const cartItem = document.createElement('div');
      cartItem.classList.add('cart-item');

      cartItem.innerHTML = `
          <img src="/path/to/shoe1.jpg" alt="Chaussure">
          <div class="cart-details">
              <h3>${item.model}</h3>
              <p>Taille : ${item.size}</p>
              <p>${item.price}</p>
          </div>
          <div class="cart-actions">
              <button class="remove-item">Supprimer</button>
          </div>
      `;

      cartContainer.appendChild(cartItem);

      // Add event listener for removing item
      cartItem.querySelector('.remove-item').addEventListener('click', () => {
          const index = cart.findIndex(
              cartItem => cartItem.model === item.model && cartItem.size === item.size
          );

          if (index > -1) {
              cart.splice(index, 1);
              localStorage.setItem('cart', JSON.stringify(cart));
              window.location.reload();
          }
      });
  });
});
function changeShoe(shoeId) {
  const productImages = document.querySelectorAll('.shoe-image');
  
  // Cache toutes les images au début
  productImages.forEach(image => {
      image.style.display = 'none';
  });

  // Affiche l'image sélectionnée en fonction de l'ID
  document.getElementById('shoe-image-' + shoeId).style.display = 'block';

  // Mettez à jour le nom et le prix du produit en fonction de l'ID
  const productName = document.getElementById('product-name');
  const productPrice = document.getElementById('product-price');

  if (shoeId === '1') {
      productName.textContent = 'Nike Air Max Plus';
      productPrice.textContent = '199,99 €';
  } else if (shoeId === '2') {
      productName.textContent = 'Nike Air Max Plus';
      productPrice.textContent = '149,99 €';
  } else if (shoeId === '3') {
      productName.textContent = 'Nike Air Max Plus';
      productPrice.textContent = '129,99 €';
  }
}

// Au début, afficher la première image et masquer les autres
window.onload = function() {
  changeShoe('1');
};
