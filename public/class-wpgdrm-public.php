<?php
/**
 * Public functions plugin
 * The public-specific functionality of the plugin.
 *
 * @package Wpgdrm
 * @subpackage Wpgdrm/public
 * @author Wilson Cavalcante <hello@gasoline.digital>
 * @since 1.0.0
 */
class Wpgdrm_Public{
	/**
	 * The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 */
	private $version;

	/**
	 * The icon of this plugin.
	 */
	private $icon;


	/**
	 * The optons of this plugin.
	 */
	private $options;


	/**
	 * Initialize the class and set its properties.
	 */
	public function __construct( $plugin_name, $version, $icon ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->icon = $icon;
		$this->options = get_option( 'wpgdrm_settings' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpfc_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpfc_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( "wpgdrm-public.css", plugin_dir_url( __FILE__ ) . 'css/wpgdrm-public.css', array(), $this->version, 'all' );

	}


	/**
	 * Showing featured in the content.
	*/
	public function wpgdrm_add_readmore($content){
		global $post, $wp_query;

		if(is_feed()){
			return $content;
		}

		if($post->post_type != 'post'){
			return $content;
		}

		if(has_shortcode($content,'tdc_zone')){
			return $content;
		}

		if(substr_count($content, '<p>') < 2 ){
			return $content;
		}



		$position = $this->get_position($post);
		$number = $this->get_number($post);

		$filter = $this->get_filter($post);

		$sorting = $this->get_sorting($post);

		$especific = $this->get_especific($post);

		if($this->is_active($post)){
			// Amp is disable?
			if(!$this->is_amp($post) && is_amp_endpoint()){
				return $content;
			}

			$printed = 0;

			//Especific Posts
			$especific_query = false;
			if(count($especific) > 0){
				$args_array = array(
					'post_type' => 'post',
					'post__not_in' => array($post->ID),
					'posts_per_page' => $number,

				);
				$espc_array = $this->set_especific($especific,$post,$number);
				$args = array_merge($args_array,$espc_array);

				$more_query = new WP_Query($args);

				if($more_query->have_posts()){
					$printed = $more_query->post_count;
					$especific_query = $more_query;
				}
				wp_reset_postdata();

			}



			$sort_array = $this->set_sorting($sorting);
			$fil_array = $this->set_filter($filter,$post);
			$args_array = array(
				'post_type' => 'post',
				'post__not_in' => array($post->ID),
				'posts_per_page' => ($number - $printed),

			);
			$args = array_merge($args_array,$fil_array,$sort_array);

			//var_dump($args);
			$more_query = false;
			if(($number - $printed) > 0){
				$more_query = new WP_Query($args);
			}


			if($more_query || $especific_query){
				$html = $this->make($more_query,$especific_query,$post);
				$content = $this->insert($html, $content, $position);
			}
			wp_reset_postdata();
		}

		return $content;
	}

	/**
	 * Check Read More Enable
	*/
	public function is_enable(){
		$options = $this->options;
		$enable = false;
		if(isset($options['wpgdrm_checkbox_enable']))
			$enable = boolval($options['wpgdrm_checkbox_enable']);

		return $enable;

	}

	/**
	 * Check Read More Auto Mode ON
	*/
	public function is_auto(){
		// Global Settings
		$options = $this->options;
		$auto = false;
		if(isset($options['wpgdrm_checkbox_auto']))
			$auto = boolval($options['wpgdrm_checkbox_auto']);

		return $auto;

	}

	/**
	 * Check Read More Is Active Current Post
	*/
	public function is_active($post){
		$active = $this->is_auto();
		if($active){
			if(boolval(get_post_meta($post->ID, 'wpgdrm_post_disable', true))){
				$active = false;
			}
		}else{
			if(boolval(get_post_meta($post->ID, 'wpgdrm_post_enable', true))){
				$active = true;
			}
		}
		return $active;
	}

	/**
	 * Check Thumb Is Active Current Post
	*/
	public function is_thumb($post){
		// Global Settings
		$thumb = false;
		$options = $this->options;
		if(isset($options['wpgdrm_checkbox_thumb']))
			$thumb = boolval($options['wpgdrm_checkbox_thumb']);

		// Post Setting
		if($thumb){
			if(boolval(get_post_meta($post->ID, 'wpgdrm_post_disable_thumbnail', true))){
				$thumb = false;
			}
		}else{
			if(boolval(get_post_meta($post->ID, 'wpgdrm_post_enable_thumbnail', true))){
				$thumb = true;
			}
		}
		return $thumb;
	}

	/**
	 * Check Read More is Active AMP Version Current Post
	*/
	public function is_amp($post){
		// Global Settings
		$amp = false;
		$options = $this->options;

		if(isset($options['wpgdrm_checkbox_amp']))
			$amp = boolval($options['wpgdrm_checkbox_amp']);

		// Post Setting
		if($amp){
			if(boolval(get_post_meta($post->ID, 'wpgdrm_post_disable_amp', true))){
				$amp = false;
			}
		}else{
			if(boolval(get_post_meta($post->ID, 'wpgdrm_post_enable_amp', true))){
				$amp = true;
			}
		}
		return $amp;
	}

	/**
	 * Get Read More Position
	*/
	public function get_position($post){
		// Global Settings
		$position = '3';
		$options = $this->options;

		if (isset($options['wpgdrm_text_position'])){
			if(is_numeric($options['wpgdrm_text_position'])){
				$position = $options['wpgdrm_text_position'];
			}

		}

		// Post Setting
		$post_position = get_post_meta($post->ID, 'wpgdrm_post_position', true);
		if(is_numeric($post_position) && $post_position > 0){
			$position = $post_position;
		}

		return $position;
	}


	/**
	 * Get Number Related Posts
	*/
	public function get_number($post){
		// Global Settings
		$number = '2';
		$options = $this->options;

		if (isset($options['wpgdrm_text_number'])){
			if(is_numeric($options['wpgdrm_text_number'])){
				$number = $options['wpgdrm_text_number'];
			}

		}

		// Post Setting
		$post_number = get_post_meta($post->ID, 'wpgdrm_post_number', true);
		if(is_numeric($post_number) && $post_number > 0){
			$number = $post_number;
		}

		return $number;
	}

	/**
	 * Get Title Read More Box
	*/
	public function get_title($post){
		// Global Settings
		$title = 'Read More';
		$options = $this->options;

		if (isset($options['wpgdrm_text_title'])){
			if(!empty($options['wpgdrm_text_title'])){
				$title = $options['wpgdrm_text_title'];
			}

		}

		return $title;
	}

	/**
	 * Get Filter Current Post
	*/
	public function get_filter($post){
		// Global Settings
		$filter = 'random';
		$options = $this->options;

		if (isset($options['wpgdrm_option_filters'])){
			if(!empty($options['wpgdrm_option_filters'])){
				$filter = $options['wpgdrm_option_filters'];
			}

		}

		// Post Setting
		$post_filter = get_post_meta($post->ID, 'wpgdrm_post_filter', true);
		if(!empty($post_filter)){
			$filter = $post_filter;
		}

		return $filter;
	}

	/**
	 * Get Sorting Current Post
	*/
	public function get_sorting($post){
		// Global Settings
		$sort = 'random';
		$options = $this->options;

		if (isset($options['wpgdrm_option_sorting'])){
			if(!empty($options['wpgdrm_option_sorting'])){
				$sort = $options['wpgdrm_option_sorting'];
			}

		}

		// Post Setting
		$post_sort = get_post_meta($post->ID, 'wpgdrm_post_sorting', true);
		if(!empty($post_sort)){
			$sort = $post_sort;
		}

		return $sort;
	}

	/**
	 * Get Especific Post
	*/
	public function get_especific($post){
		// Global Settings
		$especifics = array();
		$number = $this->get_number($post);

		for($x=1; $x <= $number; $x++){
			$field = "wpgdrm_post_especific_$x";
			$post_especific = get_post_meta($post->ID, $field, true);
			if(!empty($post_especific)){
				$especifics[] = $post_especific;
			}
		}

		return $especifics;
	}

	/**
	 * Set Sorting Array
	*/
	public function set_sorting($sort){
		$arr = array();
		switch ($sort) {
			case 'random':
				$arr = array('orderby' => 'rand');
				break;
			case 'newest':
				$arr = array('orderby' => 'date', 'order' => 'DESC');
				break;
			case 'oldest':
				$arr = array('orderby' => 'date', 'order' => 'ASC');
				break;
		}
		return $arr;
	}


	/**
	 * Set Filter Array
	*/
	public function set_filter($filter,$post){
		$arr = array();
		switch ($filter) {
			case 'random':
				$arr = array();
				break;
			case 'same_category':
				$categories = get_the_category($post->ID);
				$cats = array();

				foreach($categories as $item){
					$cats[] = $item->term_id;
				}

				$arr = array('category__in' => $cats);
				break;
			case 'same_tag':
				$tags = get_the_tags($post->ID);
				$tagslist = array();

				foreach($tags as $item){
					$tagslist[] = $item->term_id;
				}

				$arr = array('tag__in' => $tagslist);
				break;
		}
		return $arr;
	}

	/**
	 * Set Especific Post Array
	*/
	public function set_especific($filter,$post,$number){
		$arr = array();
		if(count($filter) > 0){
			$id = array();
			foreach ($filter as $item) {
				if(is_numeric($item)){
					$id[] = $item;
				}else{
					$_post = get_page_by_path($item, OBJECT, 'post');
					if($_post){
						$id[] = $_post->ID;
					}
				}
			}

			if(count($id) > 0){
				$arr['post__in'] = $id;
			}
		}
		return $arr;
	}

	/**
	 * Make Read More Box
	*/
	public function make($custom_query,$especific_query,$cpost){
		$thumb = $this->is_thumb($cpost);
		$title = $this->get_title($cpost);

		$html  =  '<div class="wpgdrm" id="wpgdrm">';
		$html  .= "<h5>$title</h5>";
		$html  .= '<ul class="wpgdrm-list">';
		if($especific_query != false){
			$html  .= $this->loop($especific_query,$thumb,$title);
		}
		if($custom_query != false){
			$html  .= $this->loop($custom_query,$thumb,$title);
		}

		$html  .= '</ul>';
		$html  .= '</div>';

		return $html;
	}

	/**
	 * Loop Posts
	*/
	public function loop($custom_query,$thumb,$title){
		$html = "";
		while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$categs = get_the_category();
				$cat = "";
				$cat_child = "";
				foreach($categs as $item){
					$cat = $item;
					if($item->parent > 0){
						$cat_child = $item;
						continue;
					}
				}
				if(empty($cat_child)){
					$cat_child = $cat;
				}


				$html  .= '<li>';
			$html  .= '<article>';
    		if($thumb){
    			$html  .= '<div class="wpgdrm-thumbnail">';
    			$html  .= '<a href="'.get_permalink().'">';
    			$html  .= get_the_post_thumbnail();
    			$html  .= '</a>';
    			$html  .= '</div>';
    		}
			$html  .= '<div class="wpgdrm-text">';
			$html  .= '<a href="'.get_permalink().'">';
			$html  .= '<span>'.$cat_child->name.'</span>';
			$html  .= '<h6>'.get_the_title().'<h6>';
			$html  .= '</a>';
			$html  .= '</div>';
    		$html  .= '</article>';
    		$html  .= '</li>';
    	endwhile;

		return $html;
	}


	/**
	 * Add Read More Box into Content
	*/
	public function insert($html, $content, $position){

		$content = wpautop($content);

	    $closing_p = '</p>';
	    $paragraphs = explode( $closing_p, $content );

	    if(count($paragraphs) < $position){
	    	$position = count($paragraphs);
	    }

	    foreach ($paragraphs as $index => $paragraph) {
	        if ( trim( $paragraph ) ) {
	            $paragraphs[$index] .= $closing_p;
	        }

	        $n = $index + 1;


	        if ($n == $position){
	            $paragraphs[$index] .= $html;
	        }
	    }

	    $content = implode( '', $paragraphs );
		$tags = array( 'p');
		$content = preg_replace( '#<(' . implode( '|', $tags) . ')>.*?<\/$1>#s', '', $content);

	    return $content;

	}

}
