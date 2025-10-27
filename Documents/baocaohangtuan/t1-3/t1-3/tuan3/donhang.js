class DonHang {
    constructor(maDonHang, ngayDat, trangThai = "Chờ xử lý") {
        this.maDonHang = maDonHang;
        this.ngayDat = ngayDat;
        this.trangThai = trangThai;
        this.chiTietDonHang = [];
    }

    tinhTongTien() {
        return this.chiTietDonHang.reduce((sum, ct) => sum + ct.tinhThanhTien(), 0);
    }

    capNhatTrangThai(trangThaiMoi) {
        this.trangThai = trangThaiMoi;
    }
}
