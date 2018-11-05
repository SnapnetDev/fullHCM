<?php
namespace Seguce92\DomPDF;

use Dompdf\Dompdf;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Factory as ViewFactory;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\Response;

/**
 * A Laravel wrapper for DOMPDF
 *
 * @package laravel-dompdf
 * @author Barry vd. Heuvel
 */
class PDF{

    /** @var \DOMPDF  */
    protected $dompdf;

    /** @var \Illuminate\Contracts\Config\Repository  */
    protected $config;

    /** @var \Illuminate\Filesystem\Filesystem  */
    protected $files;

    /** @var \Illuminate\Contracts\View\Factory  */
    protected $view;

    protected $rendered = false;
    protected $orientation;
    protected $paper;
    protected $showWarnings;
    protected $public_path;
    protected $watermark = null;

    /**
     * @param \DOMPDF $dompdf
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param \Illuminate\View\Factory $view
     */
    public function __construct(Dompdf $dompdf, ConfigRepository $config, Filesystem $files, ViewFactory $view){
        $this->dompdf = $dompdf;
        $this->config = $config;
        $this->files = $files;
        $this->view = $view;

        $this->showWarnings = $this->config->get('dompdf.show_warnings', false);
    }

    /**
     * Get the DomPDF instance
     *
     * @return \DOMPDF
     */
    public function getDomPDF(){
        return $this->dompdf;
    }

    /**
     * Set the paper size (default A4)
     *
     * @param string $paper
     * @param string $orientation
     * @return $this
     */
    public function setPaper($paper, $orientation=null){
        $this->paper = $paper;
        if($orientation){
            $this->orientation = $orientation;
        }
        return $this;
    }

    /**
     * Show or hide warnings
     *
     * @param bool $warnings
     * @return $this
     */
    public function setWarnings($warnings){
        $this->showWarnings = $warnings;
        return $this;
    }

    /**
     * Add watermark
     */
    public function setWatermarkImage($image, $opacity = 0.6, $top = '30%', $width = '100%', $height = '100%'){
        $html = '<div style="position: fixed;
                    top: '.$top.';
                    width: '.$width.';
                    height: '.$height.';
                    text-align: center;
                    opacity: '.$opacity.';
                    z-index: -1000; ">
                    <img src="'.$image.'" alt="watermark">
                </div>';

        $this->watermark = $html;

        return $this;
    }

    /**
     * Add watermark
     */
    public function setWatermarkText($text, $size = '100px', $opacity = 0.6, $rotate = '10deg', $top = '30%'){
        $html = '<div style="position: fixed;
                    position: fixed;
                    top: '.$top.';
                    width: 100%;
                    font-size: '.$size.';
                    text-align: center;
                    opacity: '.$opacity.';
                    transform: rotate('.$rotate.');
                    transform-origin: 50% 50%;
                    z-index: -1000; ">
                    '.$text.'
                </div>';

        $this->watermark = $html;

        return $this;
    }

    /**
     * Load a HTML string
     *
     * @param string $string
     * @param string $encoding Not used yet
     * @return static
     */
    public function loadHTML($string, $encoding = null){
        if($this->watermark != null)
            $string = str_replace('</body>', $this->watermark.'</body>', $string);
        $string = $this->convertEntities($string);
        $this->dompdf->load_html($string, $encoding);
        $this->rendered = false;
        return $this;
    }

    /**
     * Load a HTML file
     *
     * @param string $file
     * @return static
     */
    public function loadFile($file){
        $this->dompdf->load_html_file($file);
        $this->rendered = false;
        return $this;
    }

    /**
     * Load a View and convert to HTML
     *
     * @param string $view
     * @param array $data
     * @param array $mergeData
     * @param string $encoding Not used yet
     * @return static
     */
    public function loadView($view, $data = array(), $mergeData = array(), $encoding = null){
        $html = $this->view->make($view, $data, $mergeData)->render();
        return $this->loadHTML($html, $encoding);
    }

    /**
     * Output the PDF as a string.
     *
     * @return string The rendered PDF as string
     */
    public function output(){
        if(!$this->rendered){
            $this->render();
        }
        return $this->dompdf->output();
    }

    /**
     * Save the PDF to a file
     *
     * @param $filename
     * @return static
     */
    public function save($filename){
        $this->files->put($filename, $this->output());
        return $this;
    }

    /**
     * Make the PDF downloadable by the user
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function download($filename = 'document.pdf' ){
        $output = $this->output();
        return new Response($output, 200, array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>  'attachment; filename="'.$filename.'"'
            ));
    }

    /**
     * Return a response with the PDF to show in the browser
     *
     * @param string $filename
     * @return \Illuminate\Http\Response
     */
    public function stream($filename = 'document.pdf' ){
        $output = $this->output();
        return new Response($output, 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'inline; filename="'.$filename.'"',
        ));
    }
    /**
     * @method render
     * @return string [html string]
     */
    protected function render(){
        if(!$this->dompdf){
            throw new Exception('DOMPDF not created yet');
        }

        $this->dompdf->set_paper($this->paper, $this->orientation);

        $this->dompdf->render();

        if ( $this->showWarnings ) {
            global $_dompdf_warnings;
            if(!empty($_dompdf_warnings) && count($_dompdf_warnings)){
                $warnings = '';
                foreach ($_dompdf_warnings as $msg){
                    $warnings .= $msg . "\n";
                }
                // $warnings .= $this->dompdf->get_canvas()->get_cpdf()->messages;
                if(!empty($warnings)){
                    throw new Exception($warnings);
                }
            }
        }
        $this->rendered = true;
    }

    /**
     * @method convertEntities
     * @param  string          $subject [String]
     * @return string                   [String]
     */
    protected function convertEntities($subject){
        $entities = array(
            '€' => '&#0128;',
            '£' => '&pound;',
        );

        foreach($entities as $search => $replace){
            $subject = str_replace($search, $replace, $subject);
        }
        return $subject;
    }

}