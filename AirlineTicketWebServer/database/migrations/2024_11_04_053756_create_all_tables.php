<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hangbay', function (Blueprint $table) {
            $table->string('MaHB')->primary();
            $table->string('TenHangBay');
        });

        Schema::create('maybay', function (Blueprint $table) {
            $table->string('MaMB')->primary();
            $table->string('TenMB');
            $table->string('MaHB');
            $table->integer('SLHang1');
            $table->integer('SLHang2');
            $table->foreign('MaHB')->references('MaHB')->on('hangbay');
        });

        Schema::create('sanbay', function (Blueprint $table) {
            $table->string('MaSB')->primary();
            $table->string('TenSB');
            $table->string('Diachi');
        });

        Schema::create('congbay', function (Blueprint $table) {
            $table->string('MaCong')->primary();
            $table->string('MaSB');
            $table->foreign('MaSB')->references('MaSB')->on('sanbay');
        });

        Schema::create('chuyenbay', function (Blueprint $table) {
            $table->string('MaCB')->primary();
            $table->string('MaMB');
            $table->string('MaSBDi');
            $table->string('MaSBDen');
            $table->string('MaCong');
            $table->time('TGBay');
            $table->dateTime('NgayGioBay');
            $table->decimal('DonGia', 10, 2);
            $table->foreign('MaMB')->references('MaMB')->on('maybay');
            $table->foreign('MaSBDi')->references('MaSB')->on('sanbay');
            $table->foreign('MaSBDen')->references('MaSB')->on('sanbay');
            $table->foreign('MaCong')->references('MaCong')->on('congbay');
        });

        Schema::create('hangghe', function (Blueprint $table) {
            $table->string('MaHG')->primary();
            $table->string('TenHG');
            $table->decimal('TiLeGia', 5, 2);
        });

        Schema::create('ghengoi', function (Blueprint $table) {
            $table->string('MaGhe')->primary();
            $table->string('MaHG');
            $table->string('MaMB');
            $table->foreign('MaHG')->references('MaHG')->on('hangghe');
            $table->foreign('MaMB')->references('MaMB')->on('maybay');
        });

        Schema::create('khach', function (Blueprint $table) {
            $table->string('MaKH')->primary();
            $table->string('Ten');
            $table->string('CCCD');
            $table->string('Sdt');
            $table->string('GioiTinh');
            $table->date('NgaySinh');
            $table->string('QuocGia');
        });

        Schema::create('taikhoan', function (Blueprint $table) {
            $table->string('MaTK')->primary();
            $table->string('Email');
            $table->string('Matkhau');
            $table->string('Ten');
            $table->string('CCCD');
            $table->string('Sdt');
            $table->foreign('MaTK')->references('MaKH')->on('khach');
        });

        Schema::create('khuyenmai', function (Blueprint $table) {
            $table->string('MaKM')->primary();
            $table->string('TenKM');
            $table->date('NgayBatDau');
            $table->date('NgayKetThuc');
            $table->decimal('PhanTramKM', 5, 2);
        });

        Schema::create('hanhly', function (Blueprint $table) {
            $table->string('MaHL')->primary();
            $table->integer('Cannang');
            $table->decimal('Gia', 10, 2);
        });

        Schema::create('phieudat', function (Blueprint $table) {
            $table->string('MaPD')->primary();
            $table->string('MaGhe');
            $table->string('MaCB');
            $table->string('MaKH');
            $table->string('MaHL')->nullable();
            $table->string('MaKM')->nullable();
            $table->string('TinhTrang');
            $table->date('NgayXuatVe');
            $table->foreign('MaGhe')->references('MaGhe')->on('ghengoi');
            $table->foreign('MaCB')->references('MaCB')->on('chuyenbay');
            $table->foreign('MaKH')->references('MaKH')->on('khach');
            $table->foreign('MaHL')->references('MaHL')->on('hanhly');
            $table->foreign('MaKM')->references('MaKM')->on('khuyenmai');
        });

        Schema::create('vecb', function (Blueprint $table) {
            $table->string('MaVe')->primary();
            $table->string('MaGhe');
            $table->string('MaKM')->nullable();
            $table->string('MaKH');
            $table->string('MaHL')->nullable();
            $table->string('MaCB');
            $table->date('NgayXuatVe');
            $table->string('Tinhtrang');
            $table->foreign('MaGhe')->references('MaGhe')->on('ghengoi');
            $table->foreign('MaKM')->references('MaKM')->on('khuyenmai');
            $table->foreign('MaKH')->references('MaKH')->on('khach');
            $table->foreign('MaHL')->references('MaHL')->on('hanhly');
            $table->foreign('MaCB')->references('MaCB')->on('chuyenbay');
        });

        Schema::create('ghechuyenbay', function (Blueprint $table) {
            $table->string('MaGhe');
            $table->string('MaCB');
            $table->string('TinhTrang');
            $table->primary(['MaGhe', 'MaCB']);
            $table->foreign('MaGhe')->references('MaGhe')->on('ghengoi');
            $table->foreign('MaCB')->references('MaCB')->on('chuyenbay');
        });

        Schema::create('ct_bcdt_thang', function (Blueprint $table) {
            $table->string('MaBCT');
            $table->integer('Thang');
            $table->string('MaCB');
            $table->integer('SoVeHang1');
            $table->integer('SoVeHang2');
            $table->decimal('DoanhThu', 15, 2);
            $table->decimal('TiLe', 5, 2);
            $table->foreign('MaCB')->references('MaCB')->on('chuyenbay');
        });

        Schema::create('trunggian', function (Blueprint $table) {
            $table->string('MaCB');
            $table->string('MaSBTG');
            $table->time('ThoiGianDung');
            $table->primary(['MaCB', 'MaSBTG']);
            $table->foreign('MaCB')->references('MaCB')->on('chuyenbay');
            $table->foreign('MaSBTG')->references('MaSB')->on('sanbay');
        });

        Schema::create('thamso', function (Blueprint $table) {
            $table->integer('TGBayToiThieu');
            $table->integer('SoSBTGToiDA');
            $table->integer('TGDungToiThieu');
            $table->integer('TGDungToiDa');
            $table->integer('TGDatVeChamNhat');
            $table->integer('TGHuyVeChamNhat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thamso');
        Schema::dropIfExists('trunggian');
        Schema::dropIfExists('ct_bcdt_thang');
        Schema::dropIfExists('ghechuyenbay');
        Schema::dropIfExists('vecb');
        Schema::dropIfExists('phieudat');
        Schema::dropIfExists('hanhly');
        Schema::dropIfExists('khuyenmai');
        Schema::dropIfExists('taikhoan');
        Schema::dropIfExists('khach');
        Schema::dropIfExists('ghengoi');
        Schema::dropIfExists('hangghe');
        Schema::dropIfExists('chuyenbay');
        Schema::dropIfExists('congbay');
        Schema::dropIfExists('sanbay');
        Schema::dropIfExists('maybay');
        Schema::dropIfExists('hangbay');
    }
}