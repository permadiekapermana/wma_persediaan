<?php
include "../config/koneksi.php";
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_combobox.php";
include "../config/fungsi_rupiah.php";


if ($_GET['module']=='dashboard'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_dashboard/dashboard.php";
  }
}

elseif ($_GET['module']=='users'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_users/users.php";
  }
}

elseif ($_GET['module']=='kategori'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman'){
  include "modul/mod_kategori/kategori.php";
  }
}

elseif ($_GET['module']=='supplier'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_supplier/supplier.php";
  }
}

elseif ($_GET['module']=='produk'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman'){
  include "modul/mod_produk/produk.php";
  }
}

elseif ($_GET['module']=='penerimaan'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman'){
  include "modul/mod_penerimaan/penerimaan.php";
  }
}

elseif ($_GET['module']=='penjualan'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman'){
  include "modul/mod_penjualan/penjualan.php";
  }
}

elseif ($_GET['module']=='grafik'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_grafik/index.php";
  }
}

elseif ($_GET['module']=='analisis'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_analisis/analisis.php";
  }
}

elseif ($_GET['module']=='laporan'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_laporan/laporan.php";
  }
}
elseif ($_GET['module']=='laporan-penjualan'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_laporan/lap_penjualan.php";
  }
}
elseif ($_GET['module']=='laporan-produk'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_laporan/lap_produk.php";
  }
}
elseif ($_GET['module']=='laporan-peramalan'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_laporan/lap_peramalan.php";
  }
}
elseif ($_GET['module']=='profile'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_profile/profile.php";
  }
}
elseif ($_GET['module']=='password'){
  if ($_SESSION['leveluser']=='Admin' OR $_SESSION['leveluser']=='Partman' OR $_SESSION['leveluser']=='Kepala Bengkel'){
  include "modul/mod_password/password.php";
  }
}
else{
  echo "<p><b>MODUL TIDAK DITEMUKAN</b></p>";
}		

?>   
