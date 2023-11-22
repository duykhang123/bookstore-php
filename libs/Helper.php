<?php
class Helper
{
    public static function cmsButton($name, $link, $id, $icon, $type = 'new')
    {
        $xhtml = '<li class="button" id="' . $id . '">';
        if ($type == 'new') {
            $xhtml .= '<a class="modal" href="' . $link . '"><span class="' . $icon . '"></span>' . $name . '</a>';
        } else if ($type == 'submit') {
            $xhtml .= '<a class="modal" href="#" onclick="javascript:submitForm(\'' . $link . '\');"><span class="' . $icon . '"></span>' . $name . '</a>';
        }
        $xhtml .= '</li>';
        return $xhtml;
    }

    public static function formatDate($format, $value)
    {
        $result = '';
        if (!empty($value) && $value != '0000-00-00') {
            $result = date($format, strtotime($value));
        }
        return $result;
    }

    public static function formatStatus($value, $link, $id)
    {
        $result = ($value == 0) ? 'unpublish' : 'publish';
        $xhtml = '<a class="jgrid hasTip" id="status-' . $id . '" href="javascript:changeStatus(\'' . $link . '\');">
                        <span class="state ' . $result . '">
                            <span class="text">Module enabled and ' . $result . '</span>
                        </span>
                    </a>';
        return $xhtml;
    }

    public static function formatACP($value, $link, $id)
    {
        $result = ($value == 0) ? 'unpublish' : 'publish';
        $xhtml = '<a class="jgrid hasTip" id="group-acp-' . $id . '" href="javascript:changeACP(\'' . $link . '\');">
                        <span class="state ' . $result . '">
                            <span class="text">Module enabled and ' . $result . '</span>
                        </span>
                    </a>';
        return $xhtml;
    }

    public static function formatSpecial($value, $link, $id)
    {
        $result = ($value == 0) ? 'unpublish' : 'publish';
        $xhtml = '<a class="jgrid hasTip" id="special-acp-' . $id . '" href="javascript:changeSpecial(\'' . $link . '\');">
                        <span class="state ' . $result . '">
                            <span class="text">Module enabled and ' . $result . '</span>
                        </span>
                    </a>';
        return $xhtml;
    }

    public static function cmsLinkSort($name, $column, $columnSort, $orderPost)
    {
        $img = '';
        $order    = ($orderPost == 'desc') ? 'asc' : 'desc';
        if ($column == $columnSort) {
            $img    = '<img src="' . TEMPLATE_URL . 'admin/main/images/admin/sort_' . $orderPost . '.png" alt="">';
        }
        $xhtml = '<a href="#" onclick="javascript:sortList(\'' . $column . '\',\'' . $order . '\')">' . $name . $img . '</a>';
        return $xhtml;
    }


    public static function cmsMessage($message)
    {
        $xhtml = '';
        if (!empty($message)) {
            $xhtml = '<dl id="system-message">
							<dt class="' . $message['class'] . '">' . ucfirst($message['class']) . '</dt>
							<dd class="' . $message['class'] . ' message">
								<ul>
									<li>' . $message['content'] . '</li>
								</ul>
							</dd>
						</dl>';
        }
        return $xhtml;
    }

    public static function cmsSelecbox($name, $class, $arrValue, $keySelect = 'default')
    {
        $xhtml = '<select name="' . $name . '" class="' . $class . '">';
        foreach ($arrValue as $key => $value) {
            if ($key == $keySelect && is_numeric($keySelect)) {
                $xhtml .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
            } else {
                $xhtml .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        $xhtml .= '</select>';
        return $xhtml;
    }


    public static function cmsInput($type, $name, $id, $value, $class = null, $size = null)
    {
        $strSize    =    ($size == null) ? '' : "size='$size'";
        $strClass    =    ($class == null) ? '' : "class='$class'";

        $xhtml = "<input type='$type' name='$name' id='$id' value='$value' $strClass $strSize>";

        return $xhtml;
    }

    // Create Row
    public static function cmsRowForm($lblName, $input, $require = false)
    {
        $strRequired = '';
        if ($require == true) $strRequired = '<span class="star">&nbsp;*</span>';
        $xhtml = '<li><label>' . $lblName . $strRequired . '</label>' . $input . '</li>';

        return $xhtml;
    }

    // Create Row
    public static function cmsRow($lblName, $input, $submit = false)
    {
        if ($submit == false) {
            $xhtml = '<div class="form_row"><label class="contact"><strong>' . $lblName . ':</strong></label>' . $input . '</div>';
        } else {
            $xhtml = '<div class="form_row">' . $input . '</div>';
        }
        return $xhtml;
    }


    public static function createImage($folder, $prefix, $pictureName, $attribute = null){

		$class	= !empty($attribute['class']) ? $attribute['class'] : '';
		$width	= !empty($attribute['width']) ? $attribute['width'] : '';
		$height	= !empty($attribute['height']) ? $attribute['height'] : '';
		$strAttribute	= "class='$class' width='$width' height='$height'";
		
		$picturePath	= UPLOAD_PATH . $folder . DS . $prefix . $pictureName;
		if(file_exists($picturePath)==true){
			$picture		= '<img  '.$strAttribute.' src="'.UPLOAD_URL . $folder . DS . $prefix . $pictureName.'">';
		}else{
			$picture	= '<img '.$strAttribute.' src="'.UPLOAD_URL . $folder . DS . $prefix . 'default.jpg' .'">';
		}
		
		return $picture;
	}
}
