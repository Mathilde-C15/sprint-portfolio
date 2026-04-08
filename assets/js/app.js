document.addEventListener('DOMContentLoaded', () => {
  const homePage = document.querySelector('.page-home');
  const projectPage = document.querySelector('.page-project');
  const dashboardPage = document.querySelector('.page-dashboard');

  if (homePage) {
    initHomePage(homePage);
  }

  if (projectPage) {
    initProjectPage(projectPage);
  }

  if (dashboardPage) {
    initDashboardPage(dashboardPage);
  }
});

function initHomePage(page) {
  initCategoryFilter(page);
}

function initProjectPage(page) {
  initProjectGallery(page);
}

function initDashboardPage(page) {
  initConfirmLinks(page);
  initQuillEditors(page);
  initPictureRows(page);
}

function initCategoryFilter(page) {
  const filter = page.querySelector('#category-filter');
  const cards = page.querySelectorAll('.project-card');

  if (!filter || cards.length === 0) return;

  filter.addEventListener('change', () => {
    const value = filter.value;

    cards.forEach((card) => {
      const category = card.dataset.category;
      const shouldShow = value === 'all' || category === value;
      card.style.display = shouldShow ? 'flex' : 'none';
    });
  });
}

function initConfirmLinks(page) {
  const confirmLinks = page.querySelectorAll('[data-confirm]');

  if (confirmLinks.length === 0) return;

  confirmLinks.forEach((link) => {
    link.addEventListener('click', (event) => {
      const question = link.getAttribute('data-confirm') || 'Êtes-vous sûr ?';

      if (!window.confirm(question)) {
        event.preventDefault();
      }
    });
  });
}

function initQuillEditors(page) {
  if (typeof Quill === 'undefined') return;

  const editorElements = page.querySelectorAll('[data-quill-editor]');

  if (editorElements.length === 0) return;

  editorElements.forEach((editorElement) => {
    const targetSelector = editorElement.dataset.quillTarget;
    if (!targetSelector) return;

    const hiddenInput = page.querySelector(targetSelector);
    const form = editorElement.closest('form');

    if (!hiddenInput || !form) return;

    const quill = new Quill(editorElement, {
      theme: 'snow',
      modules: {
        toolbar: [
          [{ header: [1, 2, 3, false] }],
          ['bold', 'italic', 'underline'],
          [{ list: 'ordered' }, { list: 'bullet' }],
          ['link'],
          ['clean']
        ]
      }
    });

    const initialContent = hiddenInput.value.trim();

    if (initialContent !== '') {
      quill.root.innerHTML = initialContent;
    } else if (editorElement.innerHTML.trim() !== '') {
      quill.root.innerHTML = editorElement.innerHTML;
      hiddenInput.value = editorElement.innerHTML;
    } else {
      hiddenInput.value = '';
    }

    form.addEventListener('submit', () => {
      hiddenInput.value = quill.root.innerHTML;
    });
  });
}

function initProjectGallery(page) {
  const mainProjectImage = page.querySelector('#project-detail-main-image');
  const galleryThumbs = page.querySelectorAll('[data-gallery-thumb]');

  if (!mainProjectImage || galleryThumbs.length === 0) return;

  galleryThumbs.forEach((thumb) => {
    thumb.addEventListener('click', () => {
      mainProjectImage.src = thumb.dataset.imageSrc || '';
      mainProjectImage.alt = thumb.dataset.imageAlt || '';

      galleryThumbs.forEach((item) => item.classList.remove('is-active'));
      thumb.classList.add('is-active');
    });
  });
}

function initPictureRows(page) {
  const picturesFieldset = page.querySelector('#pictures-fieldset');
  const addPictureButton = page.querySelector('#add-picture-button');
  const pictureRowTemplate = page.querySelector('#picture-row-template');

  if (!picturesFieldset || !addPictureButton || !pictureRowTemplate) return;

  const bindPictureRemoveButtons = () => {
    const removeButtons = picturesFieldset.querySelectorAll('.picture-remove');

    removeButtons.forEach((button) => {
      button.onclick = () => {
        const rows = picturesFieldset.querySelectorAll('.picture-row');
        const parentRow = button.closest('.picture-row');

        if (!parentRow) return;

        if (rows.length <= 1) {
          const inputs = parentRow.querySelectorAll('input');

          inputs.forEach((input) => {
            input.value = '';
          });

          return;
        }

        parentRow.remove();
      };
    });
  };

  bindPictureRemoveButtons();

  addPictureButton.addEventListener('click', () => {
    const clone = pictureRowTemplate.content.cloneNode(true);
    picturesFieldset.appendChild(clone);
    bindPictureRemoveButtons();
  });
}