<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.part.header')
</head>
<body>
    <section class="admin">
      <div class="row-grid">
        <div class="admin-sidebar">
                   @include('admin.part.slide')
            </div>
            <div class="admin-content">
                <div class="admin-content-top">
                    @include('admin.part.maincontenttop')
                </div>
                 <div class="admin-content-main">
                        <div class="admin-content-main-title">
                            <h1>Dashboard</h1>    
                        </div>
                        <div class="admin-content-main-content">
                            <!-- noi dung nam o day --> 
                        </div>
                    </div>
            </div>
       </div>
    </section>
    <footer>
        @include('admin.part.footer')
    </footer>
</body>
</html>