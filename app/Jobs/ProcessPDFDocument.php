<?php

namespace App\Jobs;

use App\wait_process;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
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
        $process = new Process(array("pandoc", "public/md_files/$this->token.md", "-o", "public/pdf_files/$this->token.pdf", "--template", "eisvogel", "--number-sections", "--pdf-engine", "/bin/pdflatex"));
        $process->run();
        unlink("public/md_files/$this->token.md"); //Delete md file when pdf is generated
        if ($process->isSuccessful()) {
            $this->waitprocess->status = 1;
            $this->waitprocess->save();
        } else {
            $this->waitprocess->status = -1;
            $this->waitprocess->error_message = "An error occured";
            $this->waitprocess->save();
        }
    }

    public function failed(Exception $exception)
    {

    }
}
