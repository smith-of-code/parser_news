<?php

namespace App\Jobs;

use Illuminate\Queue\Middleware\RateLimited;
use App\Models\Image;
use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ParserNewsRbcJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $jobkey = null;
    protected $url = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url='')
    {
        $this->url = $url;
        $this->jobkey = Str::slug($url);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = \Http::get($this->url);
        $hostSlug = Str::slug($response->transferStats->getRequest()->getUri()->getHost());

        $xmlObject = simplexml_load_string($response->body());
        Log::debug('parsing',['response'=>$response]);


        $jsonFormatData = json_encode($xmlObject);
        $result = json_decode($jsonFormatData, true);

        News::whereSource($hostSlug)->each(function (News $e){
            $e->delete();
        });

        Image::wherePath('%'.$hostSlug.'%')->each(function (Image $e){
            $e->delete();
        });

        \Storage::disk('public')->deleteDirectory('img/'.$hostSlug);

        foreach ($result['channel']['item'] as $item){

            $news = new News();

            $news->fill([
                'name' =>$item['title']??'',
                'description'=> $item['description']??'',
                'datetime_pub'=>$item['pubDate']?Carbon::rawParse($item['pubDate'])->toDate():null,
                'author'=>$item['author']??'',
                'source'=>$hostSlug,
            ])->save();

            if (isset($item['enclosure'])){
                $imageIds = $this->saveImages(
                    $item['enclosure'],
                    Carbon::rawParse($item['pubDate'])->toDate(),
                    $hostSlug
                );
                $news->images()->sync($imageIds);
            }

        }

        ParserNewsRbcJob::dispatch($this->url);
    }

    public function saveImages(array $enclosure,\DateTime $date,$hostSlug):array
    {
        $data = $result = [];

        if (isset($enclosure['@attributes'])  ){
            $data[] = $enclosure['@attributes'];
        }else{
            $data = $enclosure;
        }

        foreach ($data as $item){
            try {
                $file = file_get_contents($item['url']);
                $fileInfo = pathinfo($item['url']);
                $path =  'img/'.$hostSlug.'/'.$date->format('Y/m/d/').Str::random().'.'.$fileInfo['extension'];
                \Storage::disk('public')->put($path,$file);
                $result[] = Image::insertGetId(['path'=>$path]);
            }catch (\ErrorException $e){

            }


        }

        return $result;
    }

    /**
     * Получить посредника, через которого должно пройти задание.
     *
     * @return array
     */
    public function middleware()
    {
        return [new RateLimited('parser_news')];
    }
}
