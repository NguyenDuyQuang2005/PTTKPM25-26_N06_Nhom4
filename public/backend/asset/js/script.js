const menuLi = document.querySelectorAll('.admin-sidebar-content > ul > li > a');

menuLi.forEach(link => {
    link.addEventListener('click', e => {
        const parentLi = link.parentNode;
        const submenu = parentLi.querySelector('ul');

        // ❗Chỉ chặn khi có submenu
        if (submenu) {
            e.preventDefault();

            // Nếu submenu đang mở → đóng lại
            if (submenu.style.height && submenu.style.height !== '0px') {
                submenu.style.height = '0px';
            } else {
                // Đóng tất cả submenu khác
                document.querySelectorAll('.admin-sidebar-content > ul > li > ul').forEach(ul => {
                    ul.style.height = '0px';
                });

                // Mở submenu này
                const submenuHeight = submenu.scrollHeight;
                submenu.style.height = submenuHeight + 'px';
            }
        }
    });
});
