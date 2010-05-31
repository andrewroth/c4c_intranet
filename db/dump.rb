require 'active_record'

puts "DB: #{ENV['db']}"

connection = ActiveRecord::Base.establish_connection(
  :adapter => 'mysql',
  :user => ENV['user'] || 'root',
  :password => '',
  :host => 'localhost',
  :database => ENV['db']
)

File.open("development_structure.sql", "w+") { |f| 
  f << ActiveRecord::Base.connection.structure_dump
}
