class ChiTietDonHang {
    constructor(sach, soLuong) {
        this.sach = sach;
        this.soLuong = soLuong;
        this.donGia = sach.giaBan;
    }

    tinhThanhTien() {
        return this.soLuong * this.donGia;
    }
}
