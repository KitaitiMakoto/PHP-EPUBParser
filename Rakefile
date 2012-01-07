task :default => 'sample:build'

namespace :sample do
  desc 'Build the test fixture EPUB'
  task :build do
    input_dir  = 'tests/fixtures/book'
    output_dir = 'tests/fixtures/'
    FileList["#{input_dir}/**/*"]
    sh "epzip #{input_dir}"
  end
end
