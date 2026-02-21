// ========== SLIDER FUNCTIONALITY ==========
const sliderSlides = document.querySelectorAll('.slide');
let sliderIndex = 0;
const sliderTotal = sliderSlides.length;

function showSlider(index) {
  if (!sliderSlides.length) return;
  if (index >= sliderTotal) sliderIndex = 0;
  else if (index < 0) sliderIndex = sliderTotal - 1;
  else sliderIndex = index;

  sliderSlides.forEach((s, i) => s.classList.toggle('active', i === sliderIndex));

  const dots = document.querySelectorAll('.dot');
  dots.forEach((d, i) => d.classList.toggle('active', i === sliderIndex));
}

function nextSlider() {
  showSlider((sliderIndex + 1) % Math.max(1, sliderTotal));
}

function prevSlider() {
  showSlider((sliderIndex - 1 + sliderTotal) % Math.max(1, sliderTotal));
}

if (sliderTotal > 0) {
  const nextBtn = document.getElementById('nextBtn');
  const prevBtn = document.getElementById('prevBtn');
  if (nextBtn) nextBtn.addEventListener('click', nextSlider);
  if (prevBtn) prevBtn.addEventListener('click', prevSlider);
  const dotsContainer = document.getElementById('dots');
  if (dotsContainer) {
    for (let i = 0; i < sliderTotal; i++) {
      const dot = document.createElement('span');
      dot.className = i === 0 ? 'dot active' : 'dot';
      dot.addEventListener('click', () => showSlider(i));
      dotsContainer.appendChild(dot);
    }
  }
  setInterval(nextSlider, 5000);
}

// ========== FILTER FUNCTIONALITY ==========
function initializeFilters() {
  const filterBtns = document.querySelectorAll('.filter-btn');
  const recipeCards = document.querySelectorAll('[data-category]');
  
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      // Update active button
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      
      const filterValue = btn.dataset.filter;
      
      // Filter cards
      recipeCards.forEach(card => {
        if (filterValue === 'all' || card.dataset.category === filterValue) {
          card.style.display = 'block';
          setTimeout(() => card.classList.add('show'), 10);
        } else {
          card.classList.remove('show');
          setTimeout(() => card.style.display = 'none', 300);
        }
      });
    });
  });
}

// ========== SEARCH FUNCTIONALITY ==========
function initializeSearch() {
  const searchBox = document.getElementById('searchInput');
  if (!searchBox) return;
  
  const items = document.querySelectorAll('[data-category]');
  
  searchBox.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();
    
    items.forEach(item => {
      const text = item.textContent.toLowerCase();
      if (text.includes(searchTerm)) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  });
}

// ========== FORM HANDLING ==========
function initializeForms() {
  const loginForm = document.getElementById('loginForm');
  const signupForm = document.getElementById('signupForm');
  const contactForm = document.getElementById('contactForm');
  
  if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Вход выполнен успешно! (демо)');
      loginForm.reset();
    });
  }
  
  if (signupForm) {
    signupForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      
      if (password !== confirmPassword) {
        alert('Пароли не совпадают!');
        return;
      }
      
      alert('Регистрация успешна! (демо)');
      signupForm.reset();
    });
  }
  
  if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Спасибо за сообщение! Мы свяжемся с вами в ближайшее время.');
      contactForm.reset();
    });
  }
}

// ========== MOBILE MENU ==========
function initializeMobileMenu() {
  const hamburger = document.querySelector('.hamburger');
  const navMenu = document.querySelector('.nav-menu');
  
  if (hamburger) {
    hamburger.addEventListener('click', () => {
      navMenu.classList.toggle('active');
      hamburger.classList.toggle('active');
    });
  }
}

// ========== SMOOTH SCROLLING ==========
function initializeSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
      }
    });
  });
}

// ========== ADD TO CART ==========
function initializeCart() {
  const addToCartBtns = document.querySelectorAll('.btn-primary');
  const cartCount = localStorage.getItem('cartCount') || 0;
  
  addToCartBtns.forEach(btn => {
    if (btn.textContent.includes('Добавить в Корзину')) {
      btn.addEventListener('click', () => {
        const newCount = parseInt(cartCount) + 1;
        localStorage.setItem('cartCount', newCount);
        alert('Товар добавлен в корзину!');
      });
    }
  });
}

// ========== INITIALIZE ALL ==========
document.addEventListener('DOMContentLoaded', () => {
  initializeFilters();
  initializeSearch();
  initializeForms();
  initializeMobileMenu();
  initializeSmoothScroll();
  initializeCart();
  showSlide(0);
});

// ========== FILTER FUNCTIONALITY ==========
function initializeFilters() {
  const filterBtns = document.querySelectorAll('.filter-btn');
  const recipeCards = document.querySelectorAll('[data-category]');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filterValue = btn.dataset.filter;

      recipeCards.forEach(card => {
        if (filterValue === 'all' || card.dataset.category === filterValue) {
          card.style.display = '';
          setTimeout(() => card.classList.add('show'), 10);
        } else {
          card.classList.remove('show');
          setTimeout(() => card.style.display = 'none', 300);
        }
      });
    });
  });
}

// ========== SEARCH FUNCTIONALITY ==========
function initializeSearch() {
  const searchBox = document.getElementById('searchInput');
  if (!searchBox) return;

  const items = document.querySelectorAll('[data-category]');

  searchBox.addEventListener('input', (e) => {
    const searchTerm = e.target.value.toLowerCase();

    items.forEach(item => {
      const text = item.textContent.toLowerCase();
      item.style.display = text.includes(searchTerm) ? '' : 'none';
    });
  });
}

// ========== FORM HANDLING ==========
function initializeForms() {
  const loginForm = document.getElementById('loginForm');
  const signupForm = document.getElementById('signupForm');
  const contactForm = document.getElementById('contactForm');

  if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(loginForm);
      const name = formData.get('name') || formData.get('email') || 'Пользователь';
      localStorage.setItem('userName', name);
      localStorage.setItem('userEmail', formData.get('email') || '');
      window.location.href = 'account.html';
    });
  }

  if (signupForm) {
    signupForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(signupForm);
      const name = formData.get('name') || '';
      const email = formData.get('email') || '';
      const password = formData.get('password') || '';
      const confirm = formData.get('confirmPassword') || '';

      if (!name || !email || !password) {
        alert('Пожалуйста, заполните все поля.');
        return;
      }
      if (password !== confirm) {
        alert('Пароли не совпадают!');
        return;
      }

      // Attempt server-side registration (register.php). If it fails, fall back to demo/localStorage.
      fetch('register.php', { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
          if (data && data.success && data.url) {
            localStorage.setItem('userName', name);
            localStorage.setItem('userEmail', email);
            window.location.href = data.url;
          } else if (data && data.error) {
            alert('Ошибка: ' + data.error);
          } else {
            localStorage.setItem('userName', name);
            localStorage.setItem('userEmail', email);
            window.location.href = 'account.html';
          }
        })
        .catch(err => {
          console.warn('Registration endpoint failed:', err);
          localStorage.setItem('userName', name);
          localStorage.setItem('userEmail', email);
          window.location.href = 'account.html';
        });
    });
  }

  if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      alert('Спасибо за сообщение! Мы свяжемся с вами в ближайшее время.');
      contactForm.reset();
    });
  }
}

// ========== MOBILE MENU ==========
function initializeMobileMenu() {
  const hamburger = document.querySelector('.hamburger');
  const navMenu = document.querySelector('.nav-menu');

  if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
      navMenu.classList.toggle('active');
      hamburger.classList.toggle('active');
    });
  }
}

// ========== SMOOTH SCROLLING ==========
function initializeSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (!href.startsWith('#')) return;
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) target.scrollIntoView({ behavior: 'smooth' });
    });
  });
}

// ========== ADD TO CART ==========
function initializeCart() {
  const addToCartBtns = document.querySelectorAll('.btn-primary');
  const cartCount = parseInt(localStorage.getItem('cartCount') || '0', 10);

  addToCartBtns.forEach(btn => {
    if (btn.textContent.includes('Добавить в Корзину')) {
      btn.addEventListener('click', () => {
        const newCount = cartCount + 1;
        localStorage.setItem('cartCount', newCount);
        alert('Товар добавлен в корзину!');
      });
    }
  });
}

// ========== INITIALIZE ALL ==========
document.addEventListener('DOMContentLoaded', () => {
  initializeFilters();
  initializeSearch();
  initializeForms();
  initializeMobileMenu();
  initializeSmoothScroll();
  initializeCart();
  showSlider(0);
});

// ========== LEGACY / CARD RENDERING (kept non-conflicting) ==========
const legacyProducts = [
  { name: "cocktail", type: "drinks", image: "images/food/cocktail.jpg", link: "recipe2.html" },
  { name: "Կեսար աղցան", type: "salads", image: "images/food/kesar_axcan.png" },
  { name: "Խաշ", type: "hot Appetizers", image: "images/food/khash.jpg" },
  { name: "Սուրճ", type: "drinks", image: "images/food/coffee.jpg" },
];

const legacyCardContainer = document.getElementById("card-container");
const legacyTypeFilters = document.querySelectorAll(".type-filter");

function renderLegacyCards() {
  if (!legacyCardContainer) return;

  const activeTypes = Array.from(legacyTypeFilters)
    .filter(cb => cb.checked)
    .map(cb => cb.value);

  legacyCardContainer.innerHTML = "";

  legacyProducts.forEach(p => {
    if (activeTypes.includes(p.type)) {
      const card = document.createElement("div");
      card.className = "card";

      const img = document.createElement("img");
      img.src = p.image;
      img.alt = p.name;

      const title = document.createElement("div");
      title.textContent = p.name;

      card.appendChild(img);
      card.appendChild(title);

      if (p.link) {
        const btn = document.createElement("a");
        btn.href = p.link;
        btn.className = "btn green";
        btn.textContent = "Կարդալ ավելին";
        card.appendChild(btn);
      }

      legacyCardContainer.appendChild(card);
    }
  });
}

if (legacyTypeFilters.length > 0) {
  legacyTypeFilters.forEach(cb => cb.addEventListener("change", renderLegacyCards));
  renderLegacyCards();
}
