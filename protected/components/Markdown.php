<?php

/**
 * 描述 Markdown
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
class Markdown extends CMarkdown{

    /**
	 * Creates a markdown parser.
	 * By default, this method creates a {@link MarkdownParser} instance.
	 * @return MarkdownParser the markdown parser.
	 */
	protected function createMarkdownParser()
	{
		return new MarkdownParser;
	}

    public function processOutput($output)
	{
		$output=$this->transform($output);
		if($this->purifyOutput)
		{
			$purifier=new CHtmlPurifier;
            $purifier->options = array('Attr.EnableID'=>true,'Attr.IDPrefix'=>MarkdownParser::ID_PREFIX);
			$output=$purifier->purify($output);
		}
        
        if($this->hasEventHandler('onProcessOutput'))
		{
			$event=new COutputEvent($this,$output);
			$this->onProcessOutput($event);
			if(!$event->handled)
				echo $output;
		}
		else
			echo $output;
	}

}
?>
