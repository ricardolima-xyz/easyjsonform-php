<?php
/** Export utility for forms created with easyjsonform */
class EJFExporter {

	/** Parser for EasyJsonForm contents. $form must be a full json_decoded() structure export  */
	static function formOutput($form, $html = false) {
		$result = [];
		foreach ($form as $item) foreach (self::formItemOutput($item) as $k => $v) $result[$k] = $v;
		if (!$html)
			return $result;
		else {
			$htmlResult = '<table>';
			foreach ($result as $key => $value)
				$htmlResult.= "<tr><td><strong>$key</strong></td><td>$value</td></tr>";
			$htmlResult.= '</table>';
			return $htmlResult;
		}
	}

	static function formItemOutput($item)
	{
		$result = [];

		switch ($item->type) {
			case 'textgroup':
				foreach ($item->value as $i => $textItem)
					$result["{$item->label} - {$item->properties->items[$i]}"] = $textItem;
				break;
			case 'multiplechoice':
				foreach ($item->value as $i => $textItem)
					$result["{$item->label} - {$item->properties->items[$i]}"] = 
						$textItem ? "\u{2713}" : '';
				break;
			case 'singlechoice':
				$result[$item->label] = ($item->value === null || $item->value == 'null') ? '' :
					$item->properties->items[$item->value];
				break;
			case 'file':
				$result[$item->label] = ($item->value === null || $item->value == '') ? '' :
					$item->value;
				break;
			default:
				$result[$item->label] = ($item->value === null || $item->value == '') ? '' :
					$item->value;
				break;
		}
		return $result;
	}

}
