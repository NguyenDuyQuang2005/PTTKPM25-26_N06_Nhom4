class Sach {
    constructor(maSach, tenSach, tacGia, nhaXuatBan, giaBan, soLuongTon) {
        this.maSach = maSach;
        this.tenSach = tenSach;
        this.tacGia = tacGia;
        this.nhaXuatBan = nhaXuatBan;
        this.giaBan = giaBan;
        this.soLuongTon = soLuongTon;
    }

    capNhatSoLuong(soLuong) {
        this.soLuongTon = soLuong;
    }
}
