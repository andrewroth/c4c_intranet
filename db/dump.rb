require 'rubygems'
require 'active_record'

puts "DB: #{ENV['db']}"

connection = ActiveRecord::Base.establish_connection(
  :adapter => 'mysql',
  :username => ENV['user'] || 'root',
  :password => ENV['password'],
  :host => 'localhost',
  :database => ENV['db']
)

lines = ActiveRecord::Base.connection.structure_dump.split("\n")
for i in (1..lines.length-1)
  if lines[i] =~ /CONSTRAINT/
    if lines[i-1] =~ /(.*),/
      lines[i-1] = $1
    end
  end
end

lines.delete_if{ |line| line =~ /CONSTRAINT/ }

File.open("development_structure.sql", "w+") { |f| 
  f << lines.join("\n")
}
