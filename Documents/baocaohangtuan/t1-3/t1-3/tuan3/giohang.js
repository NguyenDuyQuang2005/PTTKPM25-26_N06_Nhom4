class GioHang {
    constructor() {
        this.danhSachSach = [];
    }

    themSach(sach) {
        this.danhSachSach.push(sach);
    }

    xoaSach(maSach) {
        this.danhSachSach = this.danhSachSach.filter(s => s.maSach !== maSach);
    }

    tinhTongTien() {
        return this.danhSachSach.reduce((sum, s) => sum + s.giaBan, 0);
    }

    xoaGioHang() {
        this.danhSachSach = [];
    }
}
