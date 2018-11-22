<?php

namespace App\Jobs;

use App\wait_process;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessPDFDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $token;
    protected $waitprocess;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($token, $file_id)
    {
        $this->token = $token;
        $this->waitprocess = wait_process::create(["file_id" => "$file_id","token" => "$token"]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $process = new Process(array("pandoc", storage_path() . "/app/md_files/$this->token.md", "-o", storage_path() . "/app/public/pdf_files/$this->token.pdf", "--template", "/usr/share/pandoc/data/templates/eisvogel", "--number-sections", "--pdf-engine", "/usr/bin/pdflatex"));
        $process->run();
        Storage::delete("md_files/$this->token.md");
        if ($process->isSuccessful()) {
            $this->waitprocess->status = 1;
            $this->waitprocess->save();
        } else {
            $this->waitprocess->status = -1;
            $this->waitprocess->error_message = "An error occured";
            $this->waitprocess->save();
            throw new ProcessFailedException($process);
        }
    }

    public function failed(Exception $exception)
    {

    }
}
