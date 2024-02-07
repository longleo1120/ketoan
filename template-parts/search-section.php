<?php 
    $name = '';
    if(is_tax('document_type')){
        if(get_queried_object()->slug == 'tieng-viet' || get_queried_object()->slug == 'tieng-anh'){
            $name = 'Tài liệu';
        }else{
            $name = get_queried_object()->name;
        }
        
    }
    $action_single = '';
    if(is_single()){
        $terms = get_the_terms( get_the_ID(), 'document_type' );
        $action_single = $terms[0]->slug;
        if($terms[0]->slug == 'tieng-viet' || $terms[0]->slug == 'tieng-anh'){
            $name = 'Tài liệu';
        }else{
            $name = $terms[0]->name;
        }
    }

    global $wpdb;
    $results = $wpdb->get_results( "SELECT DISTINCT `meta_value` FROM `a2z_postmeta` WHERE `meta_key` = 'namxuatban_doc' ORDER BY `meta_value` ASC", OBJECT );

?>


<section class="search-banner">
    <div class="container">
        <div class="wrap-search-banner">
            <h3>Tìm kiếm văn bản - biểu mẫu pháp luật</h3>
            <p>Thư viện tổng hợp tài liệu về pháp luật hàng đầu Việt Nam</p>
            <div class="wrap-filter">
                <form action="<?php echo ($action_single != '') ? '/'.$action_single : ''; ?>" method="GET" class="form-search">
                    <div class="field-group">
                        <input type="text" name="keyword" id="keyword_default" placeholder="Nhập từ khoá tìm kiếm" value="<?php echo (isset($_GET['keyword']) ) ? $_GET['keyword'] : ''; ?>" required>
                        <button class="btn-search-banner" type="submit">Tìm kiếm</button>
                    </div>
                </form>
                <div class="advance-filter" style="display:none">
                    <form action="<?php echo ($action_single != '') ? '/'.$action_single : ''; ?>" class="form-advance-filter" method="GET">
                        <input type="hidden" name="keyword_avc" class="kw-avc">
                        <div class="field-group">
<!--                             <input type="text" class="input-avc " name="s_author" placeholder="Tên tác giả" value="<?php echo (isset($_GET['s_author']) ) ? $_GET['s_author'] : ''; ?>">
                            <input type="text" class="input-avc " name="name_nxb" placeholder="Tên nhà xuất bản" value="<?php echo (isset($_GET['name_nxb']) ) ? $_GET['name_nxb'] : ''; ?>"> -->
							
							<div class="input-avc">
								<select name="s_author" id="" class="input-avc-select choise" data-placeholder="Tên tác giả">
									<option value="" selected>Tên tác giả</option>
								  	<?php
									global $wpdb;
									$results = $wpdb->get_results( "SELECT DISTINCT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'author_document'", OBJECT );
									
									$s_author  = '';
									if(isset($_GET['s_author'])){
										$s_author = $_GET['s_author'];
									}
									foreach($results as $res){
										
										if(!empty($res)){
											if($s_author ==  $res->meta_value){
												$selected_y = 'selected';
											}else{
												$selected_y = '';
											}
											echo '<option value="'.$res->meta_value.'" '.$selected_y.'>'.$res->meta_value.'</option>';
										}

									}
									?>
								</select>
							</div>
							
							<div class="input-avc">
								<select name="name_nxb" id="" class="input-avc-select choise" data-placeholder="Tên nhà xuất bản">
									<option value="">Tên nhà xuất bản</option>
								  	<?php
									$results2 = $wpdb->get_results( "SELECT DISTINCT meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'name_nxb'", OBJECT );
									
									$s_author  = '';
									if(isset($_GET['name_nxb'])){
										$s_author = $_GET['name_nxb'];
									}
									foreach($results2 as $res){
										
										if(!empty($res)){
											if($s_author ==  $res->meta_value){
												$selected_y = 'selected';
											}else{
												$selected_y = '';
											}
											echo '<option value="'.$res->meta_value.'" '.$selected_y.'>'.$res->meta_value.'</option>';
										}

									}
									?>
								</select>
							</div>
							
							<div class="input-avc">
								<select name="nam_xuatban" id="" class="input-avc-select" data-placeholder="Năm xuất bản">
									<option value="">Năm xuất bản</option>
									<?php 
										global $wpdb;
										$results = $wpdb->get_results( "SELECT DISTINCT `meta_value` FROM `a2z_postmeta` WHERE `meta_key` = 'namxuatban_doc' ORDER BY `meta_value` ASC", OBJECT );
										$selected_y = '';
										$id_y = '';
										if(isset($_GET['nam_xuatban'])){
											$id_y = $_GET['nam_xuatban'];
										}
										foreach($results as $res){
											if($id_y ==  $res->meta_value){
												$selected_y = 'selected';
											}else{
												$selected_y = '';
											}
											if(!empty($res->meta_value)){
												echo '<option value="'.$res->meta_value.'" '.$selected_y.'>'.$res->meta_value.'</option>';
											}

										}
									?>
								</select>
							</div>
								
							<div class="input-avc">
								<select name="theloai" id="type_document" class="input-avc-select" data-placeholder="Thể loại">
									<option value="">Thể loại</option>
									<?php
										$selected = '';
										$id_cn = '';
										if(isset($_GET['theloai'])){
											$slug = $_GET['theloai'];
											$id_current = explode('-',$slug);
											$id_cn = end($id_current);
										}

										$category = get_terms( array(
											'taxonomy' => 'document_type',
											'hide_empty' => false,
											'parent' => 0
										) );
										if ( !empty($category) ) :
											foreach( $category as $cat ) {
												if($id_cn ==  $cat->term_id){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												echo '<option value="'. esc_attr( $cat->slug.'-'.$cat->term_id ) .'" '.$selected.'>' . esc_attr( $cat->name ) .'</option>';
											}
										endif;

									?>
								</select>
							</div>
							
							<div class="input-avc">
								<select name="chuyennganh" id="" class="input-avc-select" data-placeholder="Chuyên ngành">
									<option value="">Chuyên ngành</option>
									<?php
										$selected = '';
										$id_cn = '';
										if(isset($_GET['chuyennganh'])){
											$slug = $_GET['chuyennganh'];
											$id_current = explode('-',$slug);
											$id_cn = end($id_current);
										}

										$category = get_terms( array(
											'taxonomy' => 'document_cat',
											'hide_empty' => false,
											'parent' => 0
										) );
										if ( !empty($category) ) :
											foreach( $category as $cat ) {
												if($id_cn ==  $cat->term_id){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												echo '<option value="'. esc_attr( $cat->slug.'-'.$cat->term_id ) .'" '.$selected.'>' . esc_attr( $cat->name ) .'</option>';
											}
										endif;

									?>

								</select>
							</div>
								
                            <button class="btn-avc-filter" type="submit">Lọc</button>
                        </div>
                    </form>
					
                </div>
                <span class="show-filter-advance">
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/filter-icon.svg" alt="" class="svg-img">  
                    Lọc nâng cao <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/arrow-down.svg" alt="" class="arrow svg-img">
                </span>
            </div>
        </div>
    </div>
</section>
<?php 
if (function_exists('rank_math_the_breadcrumbs')){
        echo '<div class="container">';
            echo rank_math_the_breadcrumbs();
        echo '</div>';
    }
?>